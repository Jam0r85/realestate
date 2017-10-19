<?php

namespace App;

use Carbon\Carbon;
use Laravel\Scout\Searchable;

class Gas extends BaseModel
{
    use Searchable;

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        $array = $this->only('expires_on');
        $array['property'] = $this->property->name;
        $array['contractor_name'] = $this->contractors->pluck('name');
        $array['contractor_email'] = $this->contractors->pluck('email');

        return $array;
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_booked' => 'boolean',
        'is_completed' => 'boolean'
    ];

    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
    protected $dates = ['expires_on','last_reminder'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['property_id','expires_on','last_reminder','is_booked','is_completed'];

	/**
	 * Scope a query to order results by the expiry date.
	 * 
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
    public function scopeOrderByExpireDate($query)
    {
    	return $query->orderBy('expires_on', 'asc');
    }

    /**
     * Scope a query to only include expired gas safe reminders.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsExpired($query)
    {
        return $query->where('expires_on', '<=', Carbon::now());
    }

    /**
     * A gas safe reminder can have many contractors.
     */
    public function contractors()
    {
    	return $this->belongsToMany('App\User');
    }

    /**
     * A gas safe reminder belongs to a property.
     */
    public function property()
    {
        return $this->belongsTo('App\Property');
    }

    /**
     * A gas safe reminder has an owner.
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


    /**
     * A gas safe reminder can have many reminders.
     */
    public function reminders()
    {
        return $this->morphMany('App\Reminder', 'parent')
            ->latest();
    }
}
