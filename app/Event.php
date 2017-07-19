<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends BaseModel
{
    use SoftDeletes;

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
    protected $dates = ['start','end'];

	/**
	 * An event belongs to a calendar.
	 */
    public function calendar()
    {
    	return $this->belongsTo('App\Calendar');
    }

    /**
     * An event belongs to the user who created it.
     */
    public function owner()
    {
    	return $this->belongsTo('App\User');
    }
}
