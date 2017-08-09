<?php

namespace App;

use Laravel\Scout\Searchable;

class StatementPayment extends BaseModel
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
    protected $with = ['statement','bank_account','parent'];

    /**
     * The attrbites that should be included in the collection.
     * 
     * @var array
     */
    protected $appends = ['group','name_formatted','method_formatted'];
    
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
        'user_id',
		'amount',
		'bank_account_id',
		'sent_at',
        'parent_type',
        'parent_id'
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
     * A statement payment was created by an owner.
     */
    public function owner()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the statement payment group name.
     * 
     * @return string
     */
    public function getGroupAttribute()
    {
        if ($this->parent_type == 'invoices') {
            return 'invoice';
        }

        if ($this->parent_type == 'expenses') {
            return 'expense';
        }

        return 'landlord';
    }

    /**
     * Get the statement payment's name formatted.
     * 
     * @return string
     */
    public function getNameFormattedAttribute()
    {
        // Set the invoice name.
        if ($this->parent_type == 'invoices') {
            return 'Invoice Payment (' . $this->parent->number . ')';
        }

        // Set the expense name.
        if ($this->parent_type == 'expenses') {
            return 'Expense Payment (' . $this->parent->name . ')';
        }

        // Return the generic name of Landlord when no parent is supplied.
        return 'Landlord Payment';
    }

    /**
     * Get the statement payment's method name formatted.
     * 
     * @return string
     */
    public function getMethodFormattedAttribute()
    {
        // We have a bank account, return the basic details.
        if ($this->bank_account) {
            return $this->bank_account->name;
        }

        // No bank account provided, just return Cash or Cheque.
        return 'Cash or Cheque';
    }
}
