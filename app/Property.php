<?php

namespace App;

use App\Settings\PropertySettings;
use App\Tenancy;
use App\Traits\DataTrait;
use App\Traits\RemindersTrait;
use App\Traits\SettingsTrait;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use Laravel\Scout\Searchable;

class Property extends BaseModel
{
	use SoftDeletes;
	use Searchable;
	use PresentableTrait;
	use DataTrait;
	use Filterable;
	use SettingsTrait;
	use RemindersTrait;

	/**
	 * The presenter for this model.
	 * 
	 * @var string
	 */
	protected $presenter = 'App\Presenters\PropertyPresenter';

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
    	$array = $this->only('house_name','house_number','address1','address2','address3','county','town','postcode','country');
    	$array['branch'] = $this->branch->name;

    	foreach ($this->owners as $owner) {
    		$names[] = $owner->present()->fullName;
    	}

    	if (isset($names) && count($names)) {
    		$array['owners'] = $names;
    	}

    	return $array;
    }

    /**
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    protected $casts = [
    	'settings' => 'array',
    	'data' => 'array'
   ];

   /**
    * The keys that are allowed to be stored in the data column.
    * 
    * @var array
    */
	public $dataKeys = [
		'bedrooms',
		'bathrooms',
		'receiption_rooms'
   	];

    /**
    * The keys that are allowed to be stored in the settings column.
    * 
    * @var array
    */
	public $settingKeys = [
		'statement_send_method'
   	];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'branch_id',
		'bank_account_id',
		'tax_band_id',
		'house_name',
		'house_number',
		'address1',
		'address2',
		'address3',
		'town',
		'county',
		'postcode',
		'country',
		'settings',
		'data'
	];

    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
	protected $dates = ['deleted_at'];

	/**
	 * A property can have invoices.
	 */
	public function invoices()
	{
		return $this
			->hasMany('App\Invoice')
			->latest();
	}

	/**
	 * A property can have many tenancies.
	 */
	public function tenancies()
	{
		return $this
			->hasMany('App\Tenancy')
			->withTrashed()
			->latest();
	}

	/**
	 * A property can have an active tenancy.
	 */
	public function activeTenancy()
	{
		return $this
			->hasOne('App\Tenancy')
			->active();
	}

	/**
	 * A property can have many expenses.
	 */
	public function expenses()
	{
		return $this
			->hasMany('App\Expense')
			->latest();
	}

	/**
	 * A property can have many expenses.
	 */
	public function unpaidExpenses()
	{
		return $this
			->hasMany('App\Expense')
			->whereNull('paid_at')
			->latest();
	}

	/**
	 * A property can have many statements through it's tenancies.
	 */
	public function statements()
	{
		return $this
			->hasManyThrough('App\Statement', 'App\Tenancy')
			->latest('period_start');
	}

	/**
	 * A property was created by an owner.
	 */
	public function owner()
	{
		return $this
			->belongsTo('App\User', 'user_id');
	}

	/**
	 * A property can belong to many users.
	 */
	public function owners()
	{
		return $this
			->belongsToMany('App\User');
	}

	/**
	 * A property can have many residents.
	 */
	public function residents()
	{
		return $this
			->hasMany('App\User');
	}

	/**
	 * Get the current residents of this property which
	 * could either by tenants living at the property
	 * or the property owner who may be living there.
	 * 
	 * @return array
	 */
	public function currentResidents()
	{
		// Active tenancy, tenants are living at the property
		if ($this->activeTenancy) {
			return $this->activeTenancy->users;
		}

		// This property has been assigned as the home address for a user(s)
		if ($this->residents) {
			return $this->residents;
		}

		return null;
	}

	/**
	 * A property belongs to a branch.
	 */
	public function branch()
	{
		return $this
			->belongsTo('App\Branch');
	}

	/**
	 * A property can have a bank account.
	 */
	public function bank_account()
	{
		return $this
			->belongsTo('App\BankAccount');
	}

	/**
	 * A property can have many gas reminders.
	 */
	public function gas()
	{
		return $this
			->hasMany('App\Gas')
			->latest();
	}

	/**
	 * A property can have many appearances.
	 */
	public function appearances()
	{
		return $this
			->hasMany('App\Appearance')
			->withTrashed()
			->latest();
	}

	/**
	 * A property can have a tax band.
	 */
	public function band()
	{
		return $this
			->belongsTo('App\TaxBand');
	}

	/**
	 * Store an expense to this property.
	 * 
	 * @param \App\Expense $expense
	 * @return \App\Expense
	 */
    public function storeExpense(Expense $expense)
    {
    	return $this->expenses()->save($expense);
    }

    /**
     * Store a tenancy to this property.
     * 
     * @param  \App\Tenancy  $tenancy
     * @return  \App\Tenancy
     */
    public function storeTenancy(Tenancy $tenancy)
    {
    	$this->tenancies()->save($tenancy);

        // Add discounts to the tenancy
        foreach ($this->owners as $user) {
            if ($discount = $user->getSetting('tenancy_service_management_discount')) {
                $tenancy->discounts()->attach($discount, ['for' => 'service']);
            }
        }

    	return $tenancy;
    }
}
