<?php

namespace App;

use App\Agreement;
use App\Statement;
use App\TenancyRent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Laracasts\Presenter\PresentableTrait;
use Laravel\Scout\Searchable;

class Tenancy extends BaseModel
{
	use SoftDeletes;
	use Searchable;
    use PresentableTrait;

    /**
     * The presenter for this model.
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\TenancyPresenter';    

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        $array = $this->only('vacated_on','name');
        $array['property'] = $this->property->name;
        $array['rent'] = $this->current_rent ? $this->current_rent->amount : null;
        $array['started'] = $this->first_agreement ? $this->first_agreement->starts_at : null;
        $array['landlords'] = $this->property->owners->pluck('name');
        $array['service'] = $this->service->name;

        return $array;
    }

	/**
	 * The attrbites that should be included in the collection.
	 * 
	 * @var array
	 */
	protected $appends = [
        'name',
        'rent_amount',
        'service_charge_amount',
        'service_charge_formatted',
        'days_overdue',
        'started_at',
        'rent_balance'
    ];

    /**
     * The relations that should be eager leader.
     * 
     * @var array
     */
    protected $with = [
        //
    ];

    /**
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    protected $casts = [
        'is_overdue' => 'boolean'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'property_id',
		'service_id',
        'is_overdue',
		'vacated_on',
        'rent_balance'
	];

    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
    protected $dates = ['vacated_on','deleted_at'];

    /**
     * Scope a query to only include tenancies which are overdue.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent
     */
    public function scopeIsOverdue($query)
    {
        return $query->where('is_overdue', '1');
    }

    /**
     * Scope a query to only include tenancies which have a positive rent amount.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent
     */
    public function scopeHasRent($query)
    {
        return $query->where('rent_balance', '>', 0);
    }

    /**
     * Scope a query to only include tenancies which have a negative rent amount.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent
     */
    public function scopeOwesRent($query)
    {
        return $query->where('rent_balance', '<', 0);
    }

    /**
     * Scope a query to only include tenancies which have a negative rent amount.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent
     */
    public function scopeOwesDeposit($query)
    {
        return $query->whereHas('deposit', function ($query) {
            $query->where('balance', '!=', 'amount');
        });
    }

    /**
     * Scope a query to only include tenancies which are active.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent
     */
    public function scopeActive($query)
    {
        return $query
            ->whereNull('vacated_on')
            ->orWhere('vacated_on', '>', Carbon::now());
    }

	/**
	 * A tenancy belongs to a single property.
	 */
    public function property()
    {
    	return $this->belongsTo('App\Property')
            ->withTrashed();
    }

    /**
     * A tenancy can have many rent amounts.
     */
    public function rents()
    {
    	return $this->hasMany('App\TenancyRent')->withTrashed()->latest('starts_at');
    }

    /**
     * A tenancy can have a current rent amount based on it starting before today.
     */
    public function currentRent()
    {
        return $this->hasOne('App\TenancyRent')->where('starts_at', '<=', Carbon::now())->latest('starts_at');
    }

    /**
     * Get the current rent for this tenancy.
     * 
     * @return integer
     */
    public function getCurrentRentAmount()
    {
        return $this->currentRent->amount ?? 0;
    }

    /**
     * A tenancy can have many users as tenants.
     */
    public function tenants()
    {
    	return $this->belongsToMany('App\User');
    }

    /**
     * A tenancy can have many landlords.
     */
    public function getLandlordsAttribute()
    {
        return $this->property->owners;
    }

    /**
     * A tenancy can have many rent payments.
     */
    public function rent_payments()
    {
    	return $this->morphMany('App\Payment', 'parent')
            ->with('method','users','owner')
            ->latest();
    }

    /**
     * A tenancy can have a last rent payment.
     */
    public function latestRentPayment()
    {
        return $this->rent_payments()
            ->latest()
            ->first();
    }

    /**
     * A tenancy can have many rental statements.
     */
    public function statements()
    {
        return $this->hasMany('App\Statement')
            ->with('invoices','invoices.invoiceGroup','invoices.items','expenses','payments')
            ->latest('period_start');
    }

    /**
     * A tenancy can have a last rental statement.
     */
    public function latestStatement()
    {
        return $this->statements
            ->first();
    }

    /**
     * A tenancy can have many agreements.
     */
    public function agreements()
    {
        return $this->hasMany('App\Agreement')
            ->latest('starts_at');
    }

    /**
     * A tenancy can have a current agreement.
     */
    public function current_agreement()
    {
        return $this->hasOne('App\Agreement')
            ->where('starts_at', '<=', Carbon::now())
            ->where('ends_at', '>', Carbon::now())
            ->orWhere('starts_at', '<=', Carbon::now())
            ->whereNull('ends_at')
            ->latest();
    }

    /**
     * A tenancy can have a first agreement.
     */
    public function first_agreement()
    {
        return $this->hasOne('App\Agreement')
            ->oldest('starts_at');
    }

    /**
     * A tenancy can belong to a service.
     */
    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    /**
     * A tenancy has an owner.
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * A tenancy can belong to many discounts.
     */
    public function discounts()
    {
        return $this->belongsToMany('App\Discount')->withPivot('for');
    }

    /**
     * A tenancy can have many service discounts applied to it.
     */
    public function service_discounts()
    {
        return $this->belongsToMany('App\Discount')->wherePivot('for', 'service');
    }

    /**
     * A tenancy can have a single deposit.
     */
    public function deposit()
    {
        return $this->hasOne('App\Deposit');
    }

    /**
     * Get the tenancy's name.
     * 
     * @return string
     */
    public function getNameAttribute()
    {
        if (count($this->tenants)) {
            return implode(' & ', $this->tenants->pluck('name')->toArray());
        }

        return 'Tenancy #' . $this->id;
    }

    /**
     * Get the tenancy's current rent amount.
     * 
     * @return integer
     */
    public function getRentAmountAttribute()
    {
    	return $this->currentRent ? $this->currentRent->amount : 0;
    }

    /**
     * Get the tenancy's current rent balance.
     * 
     * @return integer
     */
    public function getRentBalance()
    {
        return $this->rent_payments->sum('amount') - $this->statements->sum('amount');
    }

    /**
     * Get the tenancy's next statement date.
     * 
     * @return Carbon\Carbon
     */
    public function nextStatementDate()
    {
        return $this->latestStatement() ? $this->latestStatement()->period_end->addDay() : $this->started_at;
    }

    /**
     * Get the tenancy's service charge.
     * 
     * @return integer
     */
    public function getServiceChargeAmountAttribute()
    {
        return ($this->getCurrentRentAmount() * $this->calculateServiceCharge());
    }

    /**
     * Calculate tge service charge for this tenancy.
     * 
     * @return integer
     */
    protected function calculateServiceCharge()
    {
        return $this->service->charge - $this->service_discounts->sum('amount');
    }

    /**
     * Check whether the tenancy has a service charge.
     * 
     * @return bool
     */
    public function hasServiceCharge()
    {
        if ($this->service) {
            if ($this->calculateServiceCharge() > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the tenancy's service charge formatted.
     * 
     * @return string
     */
    public function getServiceChargeFormattedAttribute()
    {
        if ($this->calculateServiceCharge() < 1) {
            return ($this->calculateServiceCharge() * 100) . '%';
        } else {
            return currency($this->calculateServiceCharge());
        }
    }

    /**
     * Get the number of days that this tenancy is overdue by.
     * 
     * @return integer
     */
    public function getDaysOverdueAttribute()
    {
        if (!$this->is_overdue) {
            return null;
        }
        
        if ($this->nextStatementDate() < Carbon::now()) {
            return $this->nextStatementDate()->diffInDays(Carbon::now(), false);
        } else {
            return 0;
        }
    }

    /**
     * Get the tenancy start date.
     * 
     * @return string
     */
    public function getStartedAtAttribute()
    {
        if ($this->first_agreement) {
            return $this->first_agreement->starts_at;
        }

        return null;
    }

    /**
     * Get the tenancy landlord names in a readable format.
     * 
     * @return string
     */
    public function getLandlordNameAttribute()
    {
        if (count($this->landlords)) {
            foreach ($this->landlords as $landlord) {
                $names[] = $landlord->name;
            }
            return implode(' & ', $names);
        }

        return null;
    }

    /**
     * Get the landlord's address for this tenancy.
     */
    public function getLandlordAddressAttribute()
    {
        if (count($this->landlords)) {
            return $this->landlords->first()->home;
        }

        return null;
    }

    /**
     * Check whether the tenancy is managed or not.
     * 
     * @return boolean
     */
    public function isManaged()
    {
        // Do we have a service charge?
        if ($this->service->charge == 0) {
            return false;
        }

        // Have the tenants vacated the tenancy?
        if ($this->vacated_on) {
            return false;
        }

        return true;
    }

    /**
     * Check whether this tenancy allows new statements.
     * 
     * @return bool
     */
    public function canCreateStatement()
    {
        // Rent balance is less than the rent amount required.
        if ($this->rent_balance < $this->rent_amount) {
            return false;
        }

        // Tenancy is trashed.
        if ($this->trashed()) {
            return false;
        }

        return true;
    }

    /**
     * Check whether you can record new rent payments for this tenancy.
     * 
     * @return bool
     */
    public function canRecordRentPayment()
    {
        // Tenancy is trashed.
        if ($this->trashed()) {
            return false;
        }

        return true;
    }

    /**
     * Check whether the tenancy is overdue.
     */
    public function checkWhetherOverdue()
    {
        $overdue = false;

        // Make sure the property is managed first.
        if ($this->isManaged()) {

            // Secondly make sure there have been previous rental statements.
            if (count($this->statements)) {

                // Create a next statement date variable and add 3 days
                $next_statement_date = $this->nextStatementDate();
                $next_statement_date->addDays(3);

                // Check whether the next statement date has been passed.
                if ($next_statement_date <= Carbon::now()) {
                    $overdue = true;
                }

                // Has the tenant vacated?
                if ($this->vacated_on && $this->vacated_on <= Carbon::now()) {
                    $overdue = false;
                }
            }
        }

        return $overdue;
    }

    /**
     * Set and store whether this tenancy is overdue.
     */
    public function setOverdue()
    {
        $this->is_overdue = $this->checkWhetherOverdue();
        $this->save();
    }

    /**
     * Check whether this tenancy has a custom letting fee by looking
     * for the setting in the property owners.
     * 
     * @return boolean
     */
    public function hasCustomUserLettingFee()
    {
        if (count($this->getCustomUserLettingFees())) {
            return true;
        }

        return false;
    }

    /**
     * Get the custom letting fees for this tenancy from it's owners.
     * 
     * @return array
     */
    public function getCustomUserLettingFees()
    {
        $fees = [];

        foreach ($this->property->owners as $user) {
            if ($amount = user_setting('tenancy_service_letting_fee', $user)) {
                $fees[] = [
                    'user_name' => $user->name,
                    'user_id' => $user->id,
                    'amount' => $amount
                ];
            }
        }

        return $fees;
    }

    /**
     * Check whether this tenancy has a custom re-letting fee by looking
     * for the setting in the property owners.
     * 
     * @return boolean
     */
    public function hasCustomUserReLettingFee()
    {
        if (count($this->getCustomUserReLettingFees())) {
            return true;
        }

        return false;
    }

    /**
     * Get the custom re-letting fees for this tenancy from it's owners.
     * 
     * @return array
     */
    public function getCustomUserReLettingFees()
    {
        $fees = [];

        foreach ($this->property->owners as $user) {
            if ($amount = user_setting('tenancy_service_re_letting_fee', $user)) {
                $fees[] = [
                    'user_name' => $user->name,
                    'user_id' => $user->id,
                    'amount' => $amount
                ];
            }
        }

        return $fees;
    }

    /**
     * Get this tenancy's letting fee.
     * 
     * @return integer
     */
    public function getLettingFee()
    {
        return $this->service->letting_fee;
    }

    /**
     * Get this tenancy's re-letting fee.
     * 
     * @return integer
     */
    public function getReLettingFee()
    {
        return $this->service->re_letting_fee;
    }

    /**
     * Store a statement to this tenancy.
     * 
     * @param \App\Statement $statement
     * @return void
     */
    public function storeStatement(Statement $statement)
    {
        $this->statements()->save($statement);
    }

    /**
     * Store a tenancy rent amount against this tenancy.
     * 
     * @param \App\TenancyRent $rent
     * @return \App\TenancyRent
     */
    public function storeRentAmount(TenancyRent $rent)
    {
        $rent->user_id = Auth::user()->id;
        return $this->rents()->save($rent);
    }

    /**
     * Store a tenancy agreement against this tenancy.
     * 
     * @param \App\Agreement $agreement
     * @return \App\Agreement
     */
    public function storeAgreement(Agreement $agreement)
    {
        return $this->agreements()->save($agreement);
    }

    /**
     * Is this tenancy current active.
     * 
     * @return boolean
     */
    public function isActive()
    {
        if (is_null($this->vacated_on) || $this->vacated_on > Carbon::now()) {
            return true;
        }

        return false;
    }
}
