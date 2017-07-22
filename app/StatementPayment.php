<?php

namespace App;

use Laravel\Scout\Searchable;

class StatementPayment extends BaseModel
{
    use Searchable;
    
    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
    protected $dates = ['sent_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'statement_id',
		'amount',
		'bank_account_id',
		'sent_at'
	];

	/**
	 * A statement payment belongs to a statement.
	 */
    public function statement()
    {
    	return $this->belongsTo('App\Statement');
    }

    /**
     * A statement payment can have a payment method.
     */
    public function method()
    {
        return $this->belongsTo('App\PaymentMethod');
    }

    /**
     * A statement payment can have a parent.
     */
    public function parent()
    {
        return $this->morphTo();
    }

    /**
     * A statement payment can have many users.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * Get the statement payment's name formatted.
     * 
     * @return string
     */
    public function getNameFormattedAttribute()
    {
        if ($this->parent_type == 'invoices') {
            return 'Invoices';
        }

        return 'Landlord';
    }

    /**
     * Get the statement payment's method name formatted.
     * 
     * @return string
     */
    public function getMethodFormattedAttribute()
    {
        if ($this->method) {
            return 'Bank';
        }

        return 'Cash or Cheque';
    }
}
