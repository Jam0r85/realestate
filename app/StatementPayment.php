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
        $array['owner'] = $this->owner->present()->fullName;
        $array['bank_account'] = $this->bank_account ? $this->bank_account->account_name : null;

        foreach ($this->users as $user) {
            $users[] = [
                'name' => $user->present()->fullName,
            ];
        }

        if (isset($users) && count($users)) {
            $array['users'] = $users;
        }

        $array['tenancy'] = $this->statement->tenancy->present()->name;
        $array['property'] = $this->statement->tenancy->property->present()->fullAddress;

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
     * Get the group name for this payment.
     * 
     * @return string
     */
    public function getGroupAttribute()
    {
        if (!$this->parent_type) {
            $this->parent_type = 'landlords';
        }

        return $this->parent_type;
    }
}
