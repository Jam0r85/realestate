<?php

namespace App;

use App\BankAccount;
use App\Branch;
use App\Email;
use App\Expense;
use App\Gas;
use App\Invoice;
use App\Payment;
use App\Permission;
use App\Settings\UserSettings;
use App\SmsHistory;
use App\Tenancy;
use App\Traits\SettingsTrait;
use App\UserLogin;
use Carbon\Carbon;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;
use Laravel\Cashier\Billable;
use Laravel\Scout\Searchable;

class User extends UserBaseModel
{
    use Notifiable,
        SoftDeletes,
        Searchable,
        PresentableTrait,
        SettingsTrait,
        Filterable,
        Billable;

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
        'password',
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
     * A user can be registered to a branch.
     */
    public function branch()
    {
        return $this
            ->belongsTo(Branch::class);
    }

    /**
     * A user can be a staff member to branches.
     */
    public function staffBranches()
    {
        return $this
            ->belongsToMany(Branch::class);
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
            ->belongsToMany(Tenancy::class)
            ->withTrashed()
            ->latest();
    }

    /**
     * A user can have an active tenancy.
     */
    public function activeTenancies()
    {
        return $this
            ->belongsToMany(Tenancy::class)
            ->whereNull('vacated_on')
            ->orWhere('vacated_on', '<=', Carbon::now());
    }

    /**
     * A user can have many invoices.
     */
    public function invoices()
    {
        return $this
            ->belongsToMany(Invoice::class)
            ->latest();
    }

    /**
     * A user can have many expenses.
     */
    public function expenses()
    {
        return $this
            ->hasMany(Expense::class, 'contractor_id')
            ->latest();
    }

    /**
     * A user can have many unpaid expenses.
     */
    public function unpaidExpenses()
    {
        return $this
            ->hasMany(Expense::class, 'contractor_id')
            ->whereNull('paid_at')
            ->latest();
    }

    /**
     * A user can have many payments.
     */
    public function payments()
    {
        return $this
            ->belongsToMany(Payment::class)
            ->latest();
    }

    /**
     * A user can have many gas reminders.
     */
    public function gas()
    {
        return $this
            ->belongsToMany(Gas::class);
    }

    /**
     * A user can have many bank accounts.
     */
    public function bankAccounts()
    {
        return $this
            ->belongsToMany(BankAccount::class);
    }

    /**
     * A user can have many logins.
     */
    public function logins()
    {
        return $this
            ->hasMany(UserLogin::class)
            ->latest();
    }

    /**
     * A user can be sent many SMS messages.
     */
    public function smsSent()
    {
        return $this
            ->hasMany(SmsHistory::class, 'recipient_id')
            ->where('inbound', false)
            ->latest();
    }

    /**
     * A user can have many SMS replies.
     */
    public function smsReceived()
    {
        return $this
            ->hasMany(SmsHistory::class, 'recipient_id')
            ->where('inbound', true)
            ->latest();
    }

    /**
     * User can belong to many emails.
     */
    public function emails()
    {
        return $this
            ->belongsToMany(Email::class);
    }

    /**
     * A user can have permissions.
     */
    public function permissions()
    {
        return $this
            ->belongsToMany(Permission::class);
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
        if (count($this->activeTenancies)) {
            return $this->activeTenancies->first();
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

    /**
     * Check whether this user is the master user for this application.
     * 
     * @return boolean
     */
    public function isSuperAdmin()
    {
        if (env('APP_MASTER_USER') == $this->id) {
            return true;
        }

        return false;
    }

    /**
     * Check whether this user has permission.
     * 
     * @param  string  $slug
     * @return bool
     */
    public function hasPermission(string $slug)
    {
        return $this->permissions()->where('slug', $slug)->exists();
    }

    /**
     * Check whether this user has permission and is a staff member.
     * 
     * @param  string  $slug
     * @param  \Illuminate\Database\Eloquent\Builder  $model
     * @param  \Illuminate\Database\Eloquent  $branch
     * @return bool
     */
    public function hasPermissionIsStaff(string $slug, $branch = null)
    {
        if ($this->hasPermission($slug)) {
            if (count($this->staffBranches)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check whether this user has permission and is the owner.
     * 
     * @param  string  $slug
     * @param  \Illuminate\Database\Eloquent\Builder  $model
     * @param  string  $column
     * @return bool
     */
    public function hasPermissionIsOwner(string $slug, $model, $column = 'user_id')
    {
        if ($this->hasPermission($slug)) {
            if ($this->id == $model->$column) {
                return true;
            }
        }

        return false;
    }
}