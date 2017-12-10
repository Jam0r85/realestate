<?php

namespace App;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Event extends BaseModel
{
    use SoftDeletes;
    use Searchable;
    use Filterable;

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        $array = $this->only('title','body','starts','ends');
        $array['calendar'] = $this->calendar->name;
        return $array;
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'allDay' => 'boolean'
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['calendar_id','title','body','start','end','allDay'];

    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
    protected $dates = ['start','end','deleted_at'];

	/**
	 * An event belongs to a calendar.
	 */
    public function calendar()
    {
    	return $this->belongsTo('App\Calendar');
    }

    /**
     * An event has an owner.
     */
    public function owner()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
