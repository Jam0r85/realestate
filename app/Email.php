<?php

namespace App;

class Email extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'to',
    	'subject',
    	'body'
    ];

    /**
     * An email can belong to many users.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * An email can have many attachments.
     */
    public function attachments()
    {
        return $this->hasMany('App\EmailAttachment');
    }
}
