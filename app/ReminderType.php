<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReminderType extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    public $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'parent_type'
    ];

	/**
	 * A reminder type can have many reminders.
	 */
    public function reminders()
    {
    	return $this
            ->hasMany('App\Reminder');
    }

    /**
     * Get the reminder types for the given parent.
     * 
     * @param  mixed  $parent
     * @return \App\ReminderType
     */
    public function getByParent($parent)
    {
    	if (!$parent) {
    		return $this->get();
    	}

    	return $this->where('parent_type', $parent)->get();
    }
}
