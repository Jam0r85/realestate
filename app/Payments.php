<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['key','amount','payment_method_id','note'];

	/**
	 * A payment can belong to many users.
	 */
    public function users()
    {
    	return $this->belongsToMany('App\User');
    }

    /**
     * A payment has a parent.
     */
    public function parent()
    {
    	return $this->morphTo();
    }
}
