<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenancyRent extends Model
{
    use SoftDeletes;

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
    protected $dates = ['starts_at','deleted_at'];

    /**
     * A tenancy rent amount was created by an owner.
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get the status of this rent amount.
     * 
     * @return string
     */
    public function getStatus()
    {
        if ($this->starts_at > Carbon::now()) {
            return 'Pending';
        }

        if ($this->trashed()) {
            return 'Archived';
        }

        return 'Active';
    }
}
