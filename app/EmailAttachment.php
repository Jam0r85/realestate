<?php

namespace App;

class EmailAttachment extends BaseModel
{
	/**
	 * Indicates if the model should be timestamped.
	 * 
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array
	 */
	public $fillable = ['email_id','path'];
	
	/**
	 * An email attachment belongs to an email.
	 */
    public function email()
    {
    	return $this->belongsTo('App\Email');
    }
}
