<?php

namespace App;

use Carbon\Carbon;
use App\Settings\UserSettings;
use App\Traits\SettingsTrait;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;
use Laravel\Scout\Searchable;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends UserBaseModel
{
    use Notifiable,
        SoftDeletes,
        Searchable,
        PresentableTrait,
        SettingsTrait,
        Filterable,
        HasRolesAndAbilities;

    /**
     * The presenter for this model.
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\UserPresenter';
    
    /**
     * Set the page limit for pagination.
     * 
     * @var integer
     */
    protected $perPage = 30;

    /**
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    protected $casts = [
        'settings' => 'array'
   ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'first_name',
        'last_name',
        'company_name',
        'email',
        'phone_number',
        'phone_number_other',
        'settings',
        'property_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The keys allowed in the settings column.
     * 
     * @var array
     */
    public $settingKeys = [
        'tenancy_service_management_discount',
        'tenancy_service_letting_fee',
        'tenancy_service_re_letting_fee',
        'expense_paid_notifications',
        'expense_received_notifications',
        'rent_payment_notifications',
        'contractor_bank_account_id'
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        return $this->only(
            'title',
            'first_name',
            'last_name',
            'company_name',
            'email',
            'phone_number',
            'phone_number_other'
        );
    }

    /**
     * Scope a query to filter results who have a valid email.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasEmail($query)
    {
        return $query
            ->whereNotNull('email');
    }

    /**
     * A user can have a home address.
     */
    public function home()
    {
        return $this
            ->belongsTo('App\Property', 'property_id');
    }

    /**
     * A user can belong to a branch.
     */
    public function branch()
    {
        return $this
            ->belongsTo('App\Branch');
    }

    /**
     * A user can have an owner.
     */
    public function owner()
    {
        return $this
            ->belongsTo('App\User', 'user_id');
    }

    /**
     * A user can have many properties.
     */
    public function properties()
    {
        return $this
            ->belongsToMany('App\Property')
            ->withTrashed();
    }

    /**
     * A user can have many tenancies.
     */
    public function tenancies()
    {
        return $this
            ->belongsToMany('App\Tenancy')
            ->withTrashed()
            ->latest();
    }

    /**
     * A user can have an active tenancy.
     */
    public function activeTenancy()
    {
        return $this
            ->belongsToMany('App\Tenancy')
            ->whereNull('vacated_on')
            ->first();
    }

    /**
     * A user can have a tenancy which they are vacating.
     */
    public function vacatingTenancy()
    {
        return $this
            ->belongsToMany('App\Tenancy')
            ->where('vacated_on', '<=', Carbon::now())
            ->first();
    }

    /**
     * A user can have many invoices.
     */
    public function invoices()
    {
        return $this
            ->belongsToMany('App\Invoice')
            ->latest();
    }

    /**
     * A user can have many expenses.
     */
    public function expenses()
    {
        return $this
            ->hasMany('App\Expense', 'contractor_id')
            ->latest();
    }

    /**
     * A user can have many unpaid expenses.
     */
    public function unpaidExpenses()
    {
        return $this
            ->hasMany('App\Expense', 'contractor_id')
            ->whereNull('paid_at')
            ->latest();
    }

    /**
     * A user can have many gas reminders.
     */
    public function gas()
    {
        return $this
            ->belongsToMany('App\Gas');
    }

    /**
     * A user can have many bank accounts.
     */
    public function bankAccounts()
    {
        return $this
            ->belongsToMany('App\BankAccount');
    }

    /**
     * A user can have many logins.
     */
    public function logins()
    {
        return $this
            ->hasMany('App\UserLogin')
            ->latest();
    }

    /**
     * User has many SMS messages.
     */
    public function sms()
    {
        return $this
            ->hasMany('App\SmsHistory')
            ->latest();
    }

    /**
     * User can belong to many emails.
     */
    public function emails()
    {
        return $this
            ->belongsToMany('App\Email');
    }

    /**
     * Set the users mobile phone number.
     * 
     * @param  string  $value
     * @return void
     */
    public function setPhoneNumberAttribute($value)
    {
        $this->attributes['phone_number'] = !empty($value) ? phone($value, 'GB') : $value;
    }

    /**
     * Get the contractor bank account ID for this user.
     * 
     * @return mixed
     */
    public function getContractorBankAccountId()
    {
        // Find the contractor_bank_account_id in the user's settings
        return $this->getSetting('contractor_bank_account_id');
    }

    /**
     * Get the contractor bank account for this user.
     * 
     * @return mixed
     */
    public function getContractorBankAccount()
    {
        // We have found a bank account so we return it
        if ($account = BankAccount::find($this->getContractorBankAccountId())) {
            return $account;
        }

        return null;
    }

    /**
     * Get the current location for this user.
     * 
     * @return mixed
     */
    public function getCurrentLocation()
    {
        if ($this->activeTenancy()) {
            return $this->activeTenancy()->property;
        }

        if ($this->vacatingTenancy()) {
            return $this->vacatingTenancy()->property;
        }

        if ($this->home) {
            return $this->home;
        }

        return null;
    }

    /**
     * Check whether this user is a tenant of a tenancy.
     * 
     * @return bool
     */
    public function isTenant()
    {
        if ($this->activeTenancy()) {
            return true;
        }

        if ($this->vacatingTenancy()) {
            return true;
        }

        return false;
    }
}
