<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Tenancy extends BaseModel
{
	use SoftDeletes;
	use Searchable;

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array['property'] = $this->property->name;

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
        'rent_balance',
        'next_statement_start_date',
        'service_charge_amount',
        'service_charge_formatted',
        'days_overdue',
        'started_at'
    ];

    /**
     * The relations that should be eager leader.
     * 
     * @var array
     */
    protected $with = [];

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
		'vacated_on'
	];

    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
    protected $dates = ['vacated_on'];

    /**
     * Scope a query to only include tenancies with a rent balance.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent
     */
    public function scopeWithRentBalance($query)
    {
        return $query;
    }

	/**
	 * A tenancy belongs to a single property.
	 */
    public function property()
    {
    	return $this->belongsTo('App\Property');
    }

    /**
     * A tenancy can have many rent amounts.
     */
    public function rents()
    {
    	return $this->hasMany('App\TenancyRent')->latest('starts_at');
    }

    /**
     * A tenancy can have a current rent amount based on it starting before today.
     */
    public function current_rent()
    {
        return $this->hasOne('App\TenancyRent')
            ->where('starts_at', '<=', Carbon::now())
            ->latest('starts_at');
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
            ->latest();
    }

    /**
     * A tenancy can have a last rent payment based on the date it was created.
     */
    public function last_rent_payment()
    {
        return $this->morphOne('App\Payment', 'parent')
            ->latest();
    }

    /**
     * A tenancy can have many rental statements.
     */
    public function statements()
    {
        return $this->hasMany('App\Statement')
            ->latest('period_start');
    }

    /**
     * Get the old statements list.
     * 
     */
    public function oldStatementsList()
    {
        return $this->hasMany('App\Statement')
            ->with('invoices','invoices.items','expenses')
            ->latest('id')
            ->limit(10)
            ->get();
    }

    /**
     * A tenancy can have a last rental statement.
     */
    public function last_statement()
    {
        return $this->hasOne('App\Statement')
            ->latest('period_start');
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
     * Get the tenancy's name.
     * 
     * @return string
     */
    public function getNameAttribute()
    {
    	return implode(' & ', $this->tenants->pluck('name')->toArray());
    }

    /**
     * Get the tenancy's current rent amount.
     * 
     * @return integer
     */
    public function getRentAmountAttribute()
    {
    	return $this->current_rent ? $this->current_rent->amount : null;
    }

    /**
     * Get the tenancy's current rent balance.
     * 
     * @return integer
     */
    public function getRentBalanceAttribute()
    {
    	$payments = $this->rent_payments ? $this->rent_payments->sum('amount') : 0;
        $statement_payments = $this->statements ? $this->statements->sum('amount') : 0;

        return $payments - $statement_payments;
    }

    /**
     * Get the tenancy's next statement start date.
     * 
     * @return Carbon\Carbon
     */
    public function getNextStatementStartDateAttribute()
    {
        if ($this->last_statement) {
            return $this->last_statement->period_end->addDay();
        }

        return $this->started_at;
    }

    /**
     * Get the tenancy's service charge.
     * 
     * @return integer
     */
    public function getServiceChargeAmountAttribute()
    {
        return ($this->rent_amount * $this->calculateServiceCharge());
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
        if (!$this->service) {
            return false;
        }

        if (empty($this->service->charge)) {
            return false;
        }

        return true;
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
        
        if ($this->next_statement_start_date < Carbon::now()) {
            return $this->next_statement_start_date->diffInDays(Carbon::now(), false);
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
     * Set whether a tenancy is overdue or not.
     */
    public function setOverdueStatus()
    {
        if ($this->isManaged()) {

            // Check whether tenancy is overdue
            if ($this->next_statement_start_date < Carbon::now()) {
                $this->update(['is_overdue' => true]);
            } else {
                $this->update(['is_overdue' => false]);
            }
        }
    }
}
