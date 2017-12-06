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
     * @return  null
     */
    public function messageCreated()
    {
    	return null;
    }
}
