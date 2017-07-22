<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = ['bank_name','account_name','account_number','sort_code'];

	/**
	 * A bank account can belong to many users.
	 */
    public function users()
    {
    	return $this->belongsToMany('App\User');
    }

    /**
     * A bank account can belong to many properties.
     */
    public function properties()
    {
        return $this->belongsToMany('App\Property');
    }

    /**
     * Set the bank account's bank name.
     * 
     * @param   string
     * @return  void
     */
    public function setBankNameAttribute($value)
    {
    	$this->attributes['bank_name'] = encrypt($value);
    }

       /**
     * Set the bank account's name.
     * 
     * @param   string
     * @return  void
     */
    public function setAccountNameAttribute($value)
    {
    	$this->attributes['account_name'] = encrypt($value);
    }

       /**
     * Set the bank account's account number.
     * 
     * @param   string
     * @return  void
     */
    public function setAcountNumberAttribute($value)
    {
    	$this->attributes['account_number'] = encrypt($value);
    }

       /**
     * Set the bank account's sort code.
     * 
     * @param   string
     * @return  void
     */
    public function setSortCodeAttribute($value)
    {
    	$this->attributes['sort_code'] = encrypt($value);
    }

    /**
     * Get the bank account's bank name.
     * 
     * @param  string $value
     * @return string
     */
    public function getBankNameAttribute($value)
    {
    	return decrypt($value);
    }

       /**
     * Get the bank account's account name.
     * 
     * @param  string $value
     * @return string
     */
    public function getAccountNameAttribute($value)
    {
    	return decrypt($value);
    }

    /**
     * Get the bank account's account number.
     * 
     * @param  string $value
     * @return string
     */
    public function getAccountNumberAttribute($value)
    {
    	return decrypt($value);
    }

    /**
     * Get the bank account's sort code.
     * 
     * @param  string $value
     * @return string
     */
    public function getSortCodeAttribute($value)
    {
    	return decrypt($value);
    }
}
