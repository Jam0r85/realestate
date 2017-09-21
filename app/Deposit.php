<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'tenancy_id',
		'amount',
        'uniqud_id'
	];

	/**
	 * The attrbites that should be included in the collection.
	 * 
	 * @var array
	 */
	protected $appends = [
        'balance'
    ];

	/**
	 * A deposit was recorded by an owner.
	 */
    public function owner()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * A deposit belongs to a tenancy.
     */
    public function tenancy()
    {
    	return $this->belongsTo('App\Tenancy');
    }

    /**
     * A deposit can have many payments.
     */
    public function payments()
    {
    	return $this->morphMany('App\Payment', 'parent');
    }

    /**
     * Get the balance of this deposit.
     * 
     * @return int
     */
    public function getBalanceAttribute()
    {
    	return $this->payments->sum('amount');
    }
}
