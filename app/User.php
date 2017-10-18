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
        $array = $this->only('title','first_name','last_name','company_name','email','phone_number','phone_number_other','created_at','updated_at','home_inline');

        return $array;
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
        'password',
        'property_id',
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
    protected $dates = ['deleted_at','last_login_at'];

    /**
     * A user can belong to many roles.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    /**
     * A user can belong to many user groups.
     */
    public function groups()
    {
        return $this->belongsToMany('App\UserGroup');
    }

    /**
     * A user can belong to a home property.
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
            ->withTrashed()
            ->orderBy('address1')
            ->orderBy('house_name')
            ->orderBy('house_number');
    }

    /**
     * A user can have many tenancies.
     */
    public function tenancies()
    {
        return $this->belongsToMany('App\Tenancy')
            ->with('property','current_rent','rent_payments','tenants');
    }

    /**
     * A user can have many active tenancies.
     */
    public function activeTenancies()
    {
        return $this->belongsToMany('App\Tenancy')
            ->whereNull('vacatedOn');
    }

    /**
     * A user can have many invoices.
     */
    public function invoices()
    {
        return $this->belongsToMany('App\Invoice')
            ->with('property','payments','statement_payments','items','items.taxRate')
            ->latest();
    }

    /**
     * A user can have many expenses.
     */
    public function expenses()
    {
        return $this->belongsToMany('App\Expense')
            ->with('property','statements');
    }

    /**
     * A user can have many gas reminders.
     */
    public function gas()
    {
        return $this->belongsToMany('App\Gas');
    }

    /**
     * A user can have many logins.
     */
    public function logins()
    {
        return $this->hasMany('App\UserLogin')->latest();
    }

    /**
     * A user can have settings.
     */
    public function settings()
    {
        return new UserSettings($this);
    }

    /**
     * A user's most recent logins.
     */
    public function recentLogins()
    {
        return $this->hasMany('App\UserLogin')->latest()->limit(4);
    }

    /**
     * A user can belong to many emails.
     */
    public function emails()
    {
        return $this->belongsToMany('App\Email');
    }

    /**
     * Set the user's phone number.
     * 
     * @param  string  $value
     * @return void
     */
    public function setPhoneNumberAttribute($value)
    {
        $this->attributes['phone_number'] = !empty($value) ? phone($value, 'GB') : $value;
    }

    /**
     * Get a user's name.
     * 
     * @return string
     */
    public function getNameAttribute()
    {
        if ($this->company_name) {
            return $this->company_name;
        }

        return trim($this->first_name . ' ' . $this->last_name);
    }
}
