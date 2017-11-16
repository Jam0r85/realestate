<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

class TenancyRent extends Model
{
    use SoftDeletes;
    use PresentableTrait;

    /**
     * The presenter for this model.
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\TenancyRentPresenter';

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
     * A tenancy rent belongs to a tenancy.
     */
    public function tenancy()
    {
        return $this->belongsTo('App\Tenancy');
    }
}
