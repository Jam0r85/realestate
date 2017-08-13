<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Property extends BaseModel
{
	use SoftDeletes;
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
	 * The attrbites that should be included in the collection.
	 * 
	 * @var array
	 */
	protected $appends = ['name','short_name','name_without_postcode'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'branch_id',
		'bank_account_id',
		'display_name',
		'name',
		'house_name',
		'house_number',
		'address1',
		'address2',
		'address3',
		'town',
		'county',
		'postcode',
		'country'
	];

	/**
	 * A property can have invoices.
	 */
	public function invoices()
	{
		return $this->hasMany('App\Invoice')
			->latest();
	}

	/**
	 * A property can have recent invoices.
	 */
	public function recent_invoices()
	{
		return $this->hasMany('App\Invoice')->
			latest()
			->limit(10);
	}

	/**
	 * A property can have many tenancies.
	 */
	public function tenancies()
	{
		return $this->hasMany('App\Tenancy')
			->latest();
	}

	/**
	 * A property can have many statements through it's tenancies.
	 */
	public function statements()
	{
		return $this->hasManyThrough('App\Statement', 'App\Tenancy')
			->latest('period_start');
	}

	/**
	 * A property can have many recent statements through it's tenancies.
	 */
	public function recent_statements()
	{
		return $this->hasManyThrough('App\Statement', 'App\Tenancy')
			->latest('period_start')
			->limit(10);
	}

	/**
	 * A property was created by a user who is the owner.
	 */
	public function owner()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	/**
	 * A property can belong to many users.
	 */
	public function owners()
	{
		return $this->belongsToMany('App\User');
	}

	/**
	 * A property belongs to a branch.
	 */
	public function branch()
	{
		return $this->belongsTo('App\Branch');
	}

	/**
	 * A property can have a bank account.
	 */
	public function bank_account()
	{
		return $this->belongsTo('App\BankAccount');
	}

	/**
	 * Get the property's name.
	 * 
	 * @return string
	 */
	public function getNameAttribute()
	{
		$name = $this->short_name;
		$name .= $this->address2 ? ', ' . $this->address2 : null;
		$name .= $this->address3 ? ', ' . $this->address3 : null;
		$name .= $this->town ? ', ' . $this->town : null;
		$name .= $this->county ? ', ' . $this->county : null;
		$name .= $this->postcode ? ', ' . $this->postcode : null;

		return $name;
	}

	/**
	 * Get the property's name without it's postcode.
	 * 
	 * @return string
	 */
	public function getNameWithoutPostcodeAttribute()
	{
		$name = $this->short_name;
		$name .= $this->address2 ? ', ' . $this->address2 : null;
		$name .= $this->address3 ? ', ' . $this->address3 : null;
		$name .= $this->town ? ', ' . $this->town : null;
		$name .= $this->county ? ', ' . $this->county : null;

		return $name;
	}
	
	/**
	 * Get the property's short name.
	 * 
	 * @return string
	 */
    public function getShortNameAttribute()
    {
    	// House name is present, we return that.
    	if ($this->house_name) {
    		// Add the house name.
    		$name = $this->house_name;

    		// Add the house number if we have one.
    		if ($this->house_number) {
    			$name .= ', ' . $this->house_number;
    		}

    		// Add the address line 1 if we have one.
    		if ($this->address1) {
    			if ($this->house_number) {
    				$name .= ' ' . $this->address1;
    			} else {
    				$name .= ', ' . $this->address1;
    			}
    		}

    		return trim($name);
    	}

    	// Otherwise we return the house number and the first line of the address.
    	return trim($this->house_number . ' ' . $this->address1 ?: '');
    }

    /**
     * Get the property's name formatted (eg. for letters)
     * 
     * @return string
     */
    public function getNameFormattedAttribute()
    {
    	return str_replace(', ', '<br />', $this->name);
    }
}
