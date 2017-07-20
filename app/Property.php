<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Property extends BaseModel
{
	use SoftDeletes;
	use Searchable;

	/**
	 * The attrbites that should be included in the collection.
	 * 
	 * @var array
	 */
	protected $appends = ['name','short_name'];

    /**
     * The relations that should be eager leader.
     * 
     * @var array
     */
    protected $with = ['branch','owners'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'branch_id',
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
	 * A property can have many invoices.
	 */
	public function invoices()
	{
		return $this->hasMany('App\Invoice');
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
	 * Get the property's short name.
	 * 
	 * @return string
	 */
    public function getShortNameAttribute()
    {
    	// House name is present, we return that.
    	if ($this->house_name) {
    		return $this->house_name . ', ' . $this->house_number . ' ' . $this->address1;
    	}

    	// Otherwise we return the house number and the first line of the address.
    	return $this->house_number . ' ' . $this->address1;
    }
}
