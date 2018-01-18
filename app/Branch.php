<?php

namespace App;

use App\Calendar;
use App\Event;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

class Branch extends BaseModel
{
    use PresentableTrait,
        SoftDeletes;

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
     * A branch can have many staff
     */
    public function staff()
    {
        return $this
            ->belongsToMany(User::class);
    }

    /**
     * A branch can have many calendars.
     */
    public function calendars()
    {
        return $this
            ->hasMany(Calendar::class);
    }

    /**
     * A branch can have many events through it's calendars.
     */
    public function events()
    {
        return $this
            ->hasManyThrough(Event::class, Calendar::class);
    }
}
