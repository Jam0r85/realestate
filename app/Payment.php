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
        $array = $this->only('amount','created_at');

        // Get the method name.
        $array['method'] = $this->method->name;

        // Get the tenancy details.
        if ($this->parent_type == 'tenancies') {
            $array['tenancy'] = $this->parent->name;
            if ($this->parent->property) {
                $array['property'] = $this->parent->property->name;
            }
        }

        // Get the invoice details.
        if ($this->parent_type == 'invoices') {
            $array['invoice_number'] = $this->parent->number;
            if ($this->parent->property) {
                $array['property'] = $this->parent->property->name;
            }
        }

        // Deposit Payments
        if ($this->parent_type == 'deposits') {
            $array['tenancy'] = $this->parent->tenancy->name;
            $array['property'] = $this->parent->tenancy->property->name;
        }

        // Get the users.
        $array['users'] = $this->users->pluck('name')->toArray();

        return $array;
    }

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
    public function scopeForRent($query)
    {
        return $query->where('parent_type', 'tenancies');
    }

    /**
     * Scope a query to only include deposit payments.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent
     */
    public function scopeForDeposit($query)
    {
        return $query->where('parent_type', 'deposits');
    }

    /**
     * Scope a query to only include invoice payments.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent
     */
    public function scopeForInvoice($query)
    {
        return $query->where('parent_type', 'invoices');
    }

    /**
     * A payment can have an owner.
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
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
    	return $this->morphTo()
            ->withTrashed();
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

    /**
     * Create a new payment.
     * 
     * @param array $data
     * @return \App\Payment
     */
    public static function createPayment(array $data)
    {
        $data['key'] = str_random(30);
        return parent::create($data);
    }
}
