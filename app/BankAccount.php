<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

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
     * A bank account can have many properties.
     */
    public function properties()
    {
        return $this->hasMany('App\Property');
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

    /**
     * Get the bank account's name.
     * 
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->account_name . ' - ' . $this->bank_name . ' - ' . $this->account_number . ' - ' . $this->sort_code;
    }
}
