<?php

namespace App;

class UserLogin extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'ip'
    ];

    /**
     * Overwrite the created message.
     * 
     * @return string
     */
    public function messageCreated()
    {
    	return 'New login recorded for ' . $this->user->present()->fullName;
    }

    /**
     * A user login belongs to a user.
     */
    public function user()
    {
        return $this
            ->belongsTo('App\User');
    }
}
