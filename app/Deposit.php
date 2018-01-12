<?php

namespace App;

use App\Payment;
use App\Events\DepositWasForceDeleted;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Deposit extends BaseModel
{
    use Searchable;
    use SoftDeletes;
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'tenancy_id',
		'amount',
        'unique_id',
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
     * The attributes that should be eager loaded.
     * 
     * @var array
     */
    public $with = [
        'tenancy'
    ];

	/**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            if ($model->forceDeleting) {
                event (new DepositWasForceDeleted($model));
            }
        });
    }

    /**
     * Set the amount for this deposit.
     * 
     * @param  integer  $value
     * @return void
     */
    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = pounds_to_pence($value);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        $array = $this->only('amount','unique_id');

        $array['tenancy'] = $this->tenancy->present()->name;
        $array['property'] = $this->tenancy->property->present()->fullAddress;

        return $array;
    }
    
	/**
	 * A deposit was recorded by an owner.
	 */
    public function owner()
    {
    	return $this
            ->belongsTo('App\User', 'user_id');
    }

    /**
     * A deposit belongs to a tenancy.
     */
    public function tenancy()
    {
    	return $this
            ->belongsTo('App\Tenancy')
            ->withTrashed();
    }

    /**
     * A deposit can have many payments.
     */
    public function payments()
    {
    	return $this
            ->morphMany('App\Payment', 'parent')
            ->latest();
    }

    /**
     * A deposit can have a single certificate.
     */
    public function certificate()
    {
        return $this
            ->morphOne('App\Document', 'parent');
    }

    /**
     * Store a payment to this deposit.
     * 
     * @param  \App\Payment $payment
     * @return  \App\Payment
     */
    public function storePayment(Payment $payment)
    {
        $this
            ->payments()
            ->save($payment);

        $payment
            ->users()
            ->attach($this->tenancy->users);

        return $payment;
    }

    /**
     * Update the balance for this deposit.
     * 
     * @return void
     */
    public function updateBalance()
    {
        $this->balance = $this->payments->sum('amount');
        $this->saveWithMessage('balance updated');
    }
}