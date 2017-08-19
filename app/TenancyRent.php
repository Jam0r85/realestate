<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TenancyRent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['user_id','tenancy_id','amount','starts_at'];

    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
    protected $dates = ['starts_at'];

    /**
     * A tenancy rent amount was created by an owner.
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
