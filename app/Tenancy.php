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
        $array = $this->only('vacated_on');
        $array['name'] = $this->present()->name;
        $array['property'] = $this->property->present()->fullAddress;
        $array['rent'] = $this->present()->rentAmountPlain;
        $array['started'] = $this->first_agreement ? $this->first_agreement->starts_at : null;
        $array['landlords'] = $this->property->owners->pluck('name');
        $array['service'] = $this->service->name;

        return $array;
    }

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
     * Scope a query to only include tenancies which are archived.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent
     */
    public function scopeArchived($query)
    {
        return $query
            ->with('property','tenants','currentRent','service','deposit','rent_payments','statements')
            ->onlyTrashed();
    }

    /**
     * Scope a query to only include tenancies which are overdue.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent
     */
    public function scopeOverdue($query)
    {
        return $query
            ->with('property','tenants','currentRent','service','deposit','rent_payments','statements')
            ->where('is_overdue', '>', '0')
            ->orderBy('is_overdue', 'desc');
    }

    /**
     * Scope a query to only include tenancies which have a positive rent amount.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent
     */
    public function scopeHasRent($query)
    {
        return $query
            ->with('property','tenants','currentRent','service','deposit','rent_payments','statements')
            ->where('rent_balance', '>', 0)
            ->orderBy('rent_balance');
    }

    /**
     * Scope a query to only include tenancies which have a negative rent amount.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return  \Illuminate\Database\Eloquent
     */
    public function scopeOwesRent($query)
    {
        return $query
            ->with('property','tenants','currentRent','service','deposit','rent_payments','statements')
            ->where('rent_balance', '<', 0)
            ->orderBy('rent_balance');
    }

    /**
     * Scope a query to only include tenancies which have a deposit but wrong deposit balance.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent
     */
    public function scopeOwesDeposit($query)
    {
        return $query
            ->with('property','tenants','currentRent','service','deposit','rent_payments','statements')
            ->whereHas('deposit', function ($query) {
                $query->where('balance', '!=', 'amount');
            });
    }

    /**
     * Scope a query to only include tenancies which are active.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent
     */
    public function scopeActive($query)
    {
        return $query
            ->whereNull('vacated_on')
            ->orWhere('vacated_on', '>', Carbon::now());
    }

    /**
     * Scope a query to only include tenancies which have been vacated.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent
     */
    public function scopeVacated($query)
    {
        return $query
            ->where('vacated_on', '<=', Carbon::now());
    }

	/**
	 * The property that this tenancy belongs to.
	 */
    public function property()
    {
    	return $this->belongsTo('App\Property')->withTrashed();
    }

    /**
     * The rent amounts that this tenancy has.
     */
    public function rents()
    {
    	return $this->hasMany('App\TenancyRent')->withTrashed()->latest('starts_at');
    }

    /**
     * The current rent amount of this tenancy.
     */
    public function currentRent()
    {
        return $this->hasOne('App\TenancyRent')
            ->where('starts_at', '<=', Carbon::now())
            ->latest('starts_at');
    }

    /**
     * The tenants of the tenancy.
     */
    public function tenants()
    {
    	return $this->belongsToMany('App\User');
    }

    /**
     * The rent payments for this tenancy.
     */
    public function rent_payments()
    {
    	return $this->morphMany('App\Payment', 'parent')->latest();
    }

    /**
     * The latest rent payment for this tenancy.
     */
    public function latestRentPayment()
    {
        return $this->rent_payments->first();
    }

    /**
     * The rental statements for this tenancy.
     */
    public function statements()
    {
        return $this
            ->hasMany('App\Statement')
            ->latest('period_start');
    }

    /**
     * The tenancy agreements for this tenancy.
     */
    public function agreements()
    {
        return $this->hasMany('App\Agreement')->latest('starts_at');
    }

    /**
     * The current agreement for this tenancy.
     */
    public function currentAgreement()
    {
        return $this->hasOne('App\Agreement')
            ->where('starts_at', '<=', Carbon::now())
            ->where('ends_at', '>', Carbon::now())
            ->orWhere('starts_at', '<=', Carbon::now())
            ->whereNull('ends_at')
            ->latest();
    }

    /**
     * The first agreement for this tenancy.
     */
    public function firstAgreement()
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
    public function serviceDiscounts()
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
     * Get the service charge net amount for this tenancy by multiplying
     * the current rent amount with the calculated service charge.
     * 
     * @return integer
     */
    public function getServiceChargeNetAmount($rentAmount = null)
    {
        if (is_null($rentAmount)) {
            $rentAmount = $this->present()->rentAmountPlain;
        }

        return $rentAmount * $this->getServiceChargeWithDiscounts();
    }

    /**
     * Get the service charge including discounts applied for this tenancy.
     * 
     * @return int
     */
    public function getServiceChargeWithDiscounts()
    {
        return $this->service->charge - $this->serviceDiscounts->sum('amount');
    }

    /**
     * Get the tenancy start date.
     * 
     * @return string
     */
    public function getStartedAtAttribute()
    {
        if ($this->firstAgreement) {
            return $this->firstAgreement->starts_at;
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
        $overdue = 0;

        // Make sure the property is managed first.
        if ($this->isManaged()) {

            // Secondly make sure there have been previous rental statements.
            if (count($this->statements)) {

                // Create a next statement date variable and add 3 days
                $lastStatement = $this->statements->first();
                $next_statement_date = $lastStatement->period_end->addDay();

                // Check whether the next statement date has been passed.
                if ($next_statement_date < Carbon::now()) {
                    $overdue = $next_statement_date->diffInDays(Carbon::now());
                }
            }

            // Has the tenant vacated?
            if ($this->vacated_on && $this->vacated_on <= Carbon::now()) {
                $overdue = 0;
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
     * @param  \App\Statement  $statement  the statement we are storing.
     * @return  \App\Statement
     */
    public function storeStatement(Statement $statement)
    {
        return $this->statements()->save($statement);
    }

    /**
     * Store a rent amount to this tenancy.
     * 
     * @param  \App\TenancyRent  $rent  the rent amount we are storing.
     * @return  \App\TenancyRent
     */
    public function storeRentAmount(TenancyRent $rent)
    {
        return $this->rents()->save($rent);
    }

    /**
     * Store an agreement to this tenancy.
     * 
     * @param  \App\Agreement  $agreement  the agreement we are storing.
     * @return  \App\Agreement
     */
    public function storeAgreement(Agreement $agreement)
    {
        return $this->agreements()->save($agreement);
    }

    /**
     * Is this tenancy active?
     * 
     * @return boolean
     */
    public function isActive()
    {
        if ($this->vacated_on && $this->vacated_on < Carbon::now()) {
            return false;
        }

        return true;
    }
}
