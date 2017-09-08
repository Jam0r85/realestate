<?php

namespace App;

class Branch extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'name', 'phone_number', 'email', 'address'
	];

    /**
     * A branch can have many roles.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    /**
     * A branch can have many calendars.
     */
    public function calendars()
    {
        return $this->hasMany('App\Calendar');
    }

    /**
     * A branch can have many events through it's calendars.
     */
    public function events()
    {
        return $this->hasManyThrough('App\Event', 'App\Calendar');
    }

    public function getAddressFormattedAttribute()
    {
        return nl2br($this->address);
    }
}
