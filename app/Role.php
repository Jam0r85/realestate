<?php

namespace App;

class Role extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'branch_id'
    ];

	/**
	 * A role can belong to many branches.
	 */
    public function branch()
    {
    	return $this->belongsTo('App\Branch');
    }

    /**
     * A role can belong to many users.
     */
    public function users()
    {
    	return $this->belongsToMany('App\User');
    }

    /**
     * A role can have many permissions.
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Permission');
    }
}
