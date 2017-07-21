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
        'service_charge_formatted'
    ];

    /**
     * The relations that should be eager leader.
     * 
     * @var array
     */
    protected $with = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'property_id',
		'service_id',
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
     * A tenancy can have a current rent amount.
     */
    public function current_rent()
    {
        return $this->hasOne('App\TenancyRent')->where('starts_at', '<=', Carbon::now())->latest('starts_at');
    }

    /**
     * A tenancy can have many tenants.
     */
    public function tenants()
    {
    	return $this->belongsToMany('App\User');
    }

    /**
     * A tenancy can have many rent payments.
     */
    public function rent_payments()
    {
    	return $this->morphMany('App\Payment', 'parent')->with('method')->latest();
    }

    /**
     * A tenancy can have a last rent payment.
     */
    public function last_rent_payment()
    {
        return $this->morphOne('App\Payment', 'parent')->latest();
    }

    /**
     * A tenancy can have many rental statements.
     */
    public function statements()
    {
        return $this->hasMany('App\Statement')->latest('period_start');
    }

    /**
     * A tenancy can have a last rental statement.
     */
    public function last_statement()
    {
        return $this->hasOne('App\Statement')->latest('period_start');
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
    	return $this->current_rent->amount;
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
        return $this->last_statement ? $this->last_statement->period_end->addDay() : Carbon::now();
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
     * Check whether the tenancy is managed or not.
     * 
     * @return boolean
     */
    public function isManaged()
    {
        if ($this->service->charge == 0) {
            return false;
        }

        return true;
    }

    /**
     * Check whether this tenancy allows new statements.
     * 
     * @return boolean
     */
    public function canCreateStatement()
    {
        if ($this->rent_balance < $this->rent_amount) {
            return false;
        }

        if (!$this->isManaged()) {
            return false;
        }

        return true;
    }
}
