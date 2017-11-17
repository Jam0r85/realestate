<?php

namespace App;

use Laracasts\Presenter\PresentableTrait;

class Branch extends BaseModel
{
    use PresentableTrait;

    /**
     * The presenter for this model.
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\BranchPresenter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'name', 'phone_number', 'email', 'address', 'vat_number'
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
}
