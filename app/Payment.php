<?php

namespace App;

use Laravel\Scout\Searchable;

class Payment extends BaseModel
{
    use Searchable;

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        return $array;
    }
    
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
    protected $fillable = ['key','amount','payment_method_id','note'];

    /**
     * Scope a query to only include rent payments.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent
     */
    public function scopeRentPayments($query)
    {
        return $query->where('parent_type', 'tenancies');
    }

	/**
	 * A payment can belong to many users.
	 */
    public function users()
    {
    	return $this->belongsToMany('App\User');
    }

    /**
     * A payment has a payment method.
     */
    public function method()
    {
        return $this->belongsTo('App\PaymentMethod', 'payment_method_id');
    }

    /**
     * A payment has a parent.
     */
    public function parent()
    {
    	return $this->morphTo();
    }

    /**
     * Is this payment a rent payment?
     * 
     * @return boolean
     */
    public function isRent()
    {
        return $this->parent_type === 'tenancies';
    }
}
