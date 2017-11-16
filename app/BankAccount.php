<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Laracasts\Presenter\PresentableTrait;
use Laravel\Scout\Searchable;

class BankAccount extends BaseModel
{
    use SoftDeletes;
    use Searchable;
    use PresentableTrait;

    /**
     * The presenter for this model.
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\BankAccountPresenter';

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Filter account numbers to only index the first 4 numbers for security.
        $array['account_number'] = $this->account_number_secure;

        // Account has users, add them to the array.
        if (count($this->users)) {
            $array['users'] = $this->users->pluck('name')->toArray();
            $array['emails'] = $this->users->pluck('email')->toArray();
        }

        return $array;
    }

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = ['bank_name','account_name','account_number','sort_code'];

    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
    protected $dates = ['deleted_at'];

	/**
	 * A bank account can belong to many users.
	 */
    public function users()
    {
    	return $this->belongsToMany('App\User');
    }

    /**
     * A bank account can have an owner.
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * A bank account can have many properties.
     */
    public function properties()
    {
        return $this->hasMany('App\Property')->withTrashed();
    }

    /**
     * A bank account can have many statement payments.
     */
    public function statement_payments()
    {
        return $this->hasMany('App\StatementPayment');
    }

    /**
     * A bank account can have similar bank accounts.
     * 
     * @return \App\BankAccount
     */
    public function similarBankAccounts()
    {
        $searchTerm = $this->account_name;

        foreach ($this->users as $user) {
            $names[] = $user->present()->fullName;
        }

        if (isset($names) && count($names)) {
            $searchTerm .= ',' . implode(',', $names);
        }

        $results = BankAccount::search($searchTerm)->get();

        $filtered = $results->whereNotIn('id', $this->id);
        
        return $filtered;
    }

    /**
     * Set the bank account's account number.
     * 
     * @param   string
     * @return  void
     */
    public function setAccountNumberAttribute($value)
    {
    	$this->attributes['account_number'] = Crypt::encryptString($value);
    }

    /**
     * Set the bank account's sort code.
     * 
     * @param   string
     * @return  void
     */
    public function setSortCodeAttribute($value)
    {
    	$this->attributes['sort_code'] = Crypt::encryptString($value);
    }

    /**
     * Get the bank account's account number.
     * 
     * @param  string $value
     * @return string
     */
    public function getAccountNumberAttribute($value)
    {
    	return Crypt::decryptString($value);
    }

    /**
     * Get the bank account's sort code.
     * 
     * @param  string $value
     * @return string
     */
    public function getSortCodeAttribute($value)
    {
    	return Crypt::decryptString($value);
    }
}
