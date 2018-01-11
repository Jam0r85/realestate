<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

class TenancyRent extends BaseModel
{
    use SoftDeletes,
        PresentableTrait;

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
	protected $fillable = [
        'amount',
        'starts_at'
    ];

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
        return $this
            ->belongsTo('App\User', 'user_id');
    }

    /**
     * A tenancy rent belongs to a tenancy.
     */
    public function tenancy()
    {
        return $this
            ->belongsTo('App\Tenancy');
    }

    /**
     * Check to see whether this rent has a newer active rent.
     * 
     * @return boolean
     */
    public function hasNewerRent()
    {
        return TenancyRent::where('tenancy_id', $this->tenancy_id)
            ->where('starts_at', '>', $this->starts_at)
            ->where('starts_at', '<=', Carbon::now())
            ->count();
    }
}
