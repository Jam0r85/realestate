<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    
	/**
	 * A reminder has a parent model.
	 */
    public function parent()
    {
    	return $this->morphTo();
    }

    /**
     * A reminder belongs to a recipient.
     */
    public function recipient()
    {
    	return $this->belongsTo('App\User', 'recipient_id');
    }

    /**
     * A reminder belongs to a owner.
     */
    public function owner()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
