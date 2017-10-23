<?php

namespace App;

use Laravel\Scout\Searchable;

class Deposit extends BaseModel
{
    use Searchable;

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        $array = $this->only('amount','unique_id');

        $array['tenancy'] = $this->tenancy->name;
        $array['property'] = $this->tenancy->property->name;

        return $array;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'tenancy_id',
		'amount',
        'unique_id'
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
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    protected $casts = [
        'data' => 'array'
    ];

    /**
     * The relations that should be eager leader.
     * 
     * @var array
     */
    protected $with = ['payments'];

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
    	return $this->belongsTo('App\Tenancy')
            ->withTrashed();
    }

    /**
     * A deposit can have many payments.
     */
    public function payments()
    {
    	return $this->morphMany('App\Payment', 'parent')
            ->latest();
    }

    /**
     * A deposit can have a single certificate.
     */
    public function certificate()
    {
        return $this->morphOne('App\Document', 'parent')
            ->where('data->certificate', $this->unique_id);
    }

    /**
     * A deposit can have a last payment.
     */
    public function lastPayment()
    {
        return $this->morphOne('App\Payment', 'parent')
            ->latest();
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