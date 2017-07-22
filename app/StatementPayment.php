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
     * A statement payment can have a bank account to send the payment to.
     */
    public function bank_account()
    {
        return $this->belongsTo('App\BankAccount');
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
            return 'Invoice Payment';
        }

        if ($this->parent_type == 'expenses') {
            return 'Expense Payment';
        }

        return 'Landlord Payment';
    }

    /**
     * Get the statement payment's method name formatted.
     * 
     * @return string
     */
    public function getMethodFormattedAttribute()
    {
        if ($this->bank_account) {
            return 'Bank';
        }

        return 'Cash or Cheque';
    }
}
