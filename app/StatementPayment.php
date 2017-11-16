<?php

namespace App;

use Laracasts\Presenter\PresentableTrait;
use Laravel\Scout\Searchable;

class StatementPayment extends BaseModel
{
    use PresentableTrait;

    /**
     * The presented for this model.
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\StatementPaymentPresenter';

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        $array = $this->only('sent_at','created_at','amount');

        // Attach the owner.
        $array['owner'] = $this->owner ? $this->owner->name : null;

        // Attach the bank account
        $array['bank_account'] = $this->bank_account ? $this->bank_account->name_secure : null;

        // Attach the payment users.
        $array['users'] = $this->users ? $this->users->pluck('name','email','phone_number')->toArray() : null;

        // Attach the tenancy.
        $array['tenancy'] = $this->statement->tenancy->name;

        // Attach the property.
        $array['property'] = $this->statement->tenancy->property->name;

        return $array;
    }
    
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
		'sent_at',
        'parent_type',
        'parent_id'
	];

	/**
	 * A statement payment belongs to a statement.
	 */
    public function statement()
    {
    	return $this->belongsTo('App\Statement')->withTrashed();
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
        return $this->belongsTo('App\User', 'user_id');
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

        if ($this->parent_type == 'invoices') {
            return 'n/a';
        }

        // No bank account provided, just return Cash or Cheque.
        return 'Cash or Cheque';
    }
}
