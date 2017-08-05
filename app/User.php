<?php

namespace App;

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
        $array = $this->toArray();

        return $array;
    }
    
    /**
     * Set the page limit for pagination.
     * 
     * @var integer
     */
    protected $perPage = 20;

    /**
     * The attrbites that should be included in the collection.
     * 
     * @var array
     */
    protected $appends = ['name','home_inline','home_formatted'];

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
     * A user can have many logins.
     */
    public function logins()
    {
        return $this->hasMany('App\UserLogin')->latest();
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

    /**
     * Get the user's home address.
     * 
     * @return string
     */
    public function getHomeInlineAttribute()
    {
        return $this->home ? $this->home->name : null;
    }

    /**
     * Get the user's home address formatted (eg. for letters)
     * 
     * @return string
     */
    public function getHomeFormattedAttribute()
    {
        return $this->home ? $this->home->name_formatted : null;
    }

    /**
     * Check whether the user beongs to the corresponding group by it's id.
     * 
     * @param  integer $group_id
     * @return bool
     */
    public function inGroup($group_id)
    {
        return (boolean) $this->groups->contains($group_id);
    }

    /**
     * Check whether the user has the corresponding role by it's id.
     * 
     * @param  integer $role_id
     * @return bool
     */
    public function hasRole($role_id)
    {
        return (boolean) $this->roles->contains($role_id);
    }
}
