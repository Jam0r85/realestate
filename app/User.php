<?php

namespace App;

use App\Settings\UserSettings;
use App\Traits\SettingsTrait;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;
use Laravel\Scout\Searchable;

class User extends UserBaseModel
{
    use Notifiable;
    use SoftDeletes;
    use Searchable;
    use PresentableTrait;
    use SettingsTrait;
    use Filterable;

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
        'expense_notifications',
        'rent_payment_notifications'
    ];

    /**
     * Scope a query to filter results who have a valid email.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasEmail($query)
    {
        return $query->whereNotNull('email');
    }

    /**
     * A user can have a home.
     */
    public function home()
    {
        return $this->belongsTo('App\Property', 'property_id');
    }

    /**
     * A user can belong to a branch.
     */
    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }

    /**
     * A user can have an owner.
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * A user can have many properties.
     */
    public function properties()
    {
        return $this->belongsToMany('App\Property')->withTrashed();
    }

    /**
     * A user can have many tenancies.
     */
    public function tenancies()
    {
        return $this->belongsToMany('App\Tenancy')->withTrashed()->latest();
    }

    /**
     * A user can have many invoices.
     */
    public function invoices()
    {
        return $this->belongsToMany('App\Invoice')->latest();
    }

    /**
     * A user can be the contractor of many expenses.
     */
    public function expenses()
    {
        return $this->hasManyThrough('App\Expense', 'App\Property')->latest();
    }

    /**
     * A user can have many gas reminders.
     */
    public function gas()
    {
        return $this->belongsToMany('App\Gas');
    }

    /**
     * A user can have many bank accounts.
     */
    public function bankAccounts()
    {
        return $this->belongsToMany('App\BankAccount');
    }

    /**
     * A user can have many logins.
     */
    public function logins()
    {
        return $this->hasMany('App\UserLogin')->latest();
    }

    /**
     * User has many SMS messages.
     */
    public function sms()
    {
        return $this->hasMany('App\SmsHistory')->latest();
    }

    /**
     * User can belong to many emails.
     */
    public function emails()
    {
        return $this->belongsToMany('App\Email');
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
}
