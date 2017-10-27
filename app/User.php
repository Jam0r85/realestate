<?php

namespace App;

use App\Settings\UserSettings;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use Searchable;

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
            'phone_number_other',
            'created_at',
            'updated_at',
            'home_inline'
        );
    }
    
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
     * The attrbites that should be included in the collection.
     * 
     * @var array
     */
    protected $appends = ['name'];

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
        'settings'
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
        return $this->belongsToMany('App\Property')
            ->withTrashed();
    }

    /**
     * A user can have many tenancies.
     */
    public function tenancies()
    {
        return $this->belongsToMany('App\Tenancy')
            ->withTrashed()
            ->latest();
    }

    /**
     * A user can have an active tenancy.
     */
    public function activeTenancy()
    {
        return $this->belongsToMany('App\Tenancy')
            ->isActive()
            ->first();
    }

    /**
     * A user can have a current location.
     */
    public function currentLocation()
    {
        if ($this->activeTenancy()) {
            return $this->activeTenancy()->property->name;
        }

        if ($this->home) {
            return $this->home->name;
        }

        return null;
    }

    /**
     * A user can have many invoices.
     */
    public function invoices()
    {
        return $this->belongsToMany('App\Invoice')
            ->latest();
    }

    /**
     * A user can have many expenses.
     */
    public function expenses()
    {
        return $this->belongsToMany('App\Expense')
            ->latest();
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
        return $this->hasMany('App\UserLogin')
            ->latest();
    }

    /**
     * A user can belong to many emails.
     */
    public function emails()
    {
        return $this->belongsToMany('App\Email');
    }

    /**
     * A user can have settings.
     */
    public function settings()
    {
        return new UserSettings($this);
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
     * Get the user's name.
     * 
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->company_name ?? trim($this->first_name . ' ' . $this->last_name);
    }
}
