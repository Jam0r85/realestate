<?php

namespace App;

use App\AppearancePrice;
use App\Traits\DataTrait;
use Carbon\Carbon;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

class Appearance extends BaseModel
{
	use SoftDeletes;
	use PresentableTrait;
	use DataTrait;
	use Filterable;

	/**
	 * The presenter for this model.
	 * 
	 * @var string
	 */
	protected $presenter = 'App\Presenters\AppearancePresenter';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'slug',
		'summary',
		'description',
		'live_at'
	];

	/**
	 * The attributes that should be mutated to dates.
	 * 
	 * @var array
	 */
	protected $dates = ['live_at','deleted_at'];

	/**
	 * The attributes that should be cast to native types.
	 * 
	 * @var array
	 */
	protected $casts = [
		'hidden' => 'boolean',
		'data' => 'array'
	];

	/**
	 * The keys to be allowed in the data column.
	 * 
	 * @var array
	 */
	protected $dataKeys = [
		'agent_ref',
		'avaliable_from',
		'new_home',
		'display_address'
	];

	/**
     * The "booting" method of the model.
     *
     * @return void
     */
	public static function boot()
	{
		parent::boot();

		static::creating(function ($model) {
			$model->slug = $model->setSlug();

			return dd($model);
		});
	}

    /**
     * Scope a query to eager load the relations needed when showing a list of appearances.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent\Builder
     */
	public function scopeEagerLoading($query)
	{
		return $query->with('section','status','property');
	}

    /**
     * Scope a query to only include live appearances.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent\Builder
     */
	public function scopeLive($query)
	{
		return $query
			->where('live_at', '<=', Carbon::now())
			->latest();
	}

    /**
     * Scope a query to only include live appearances.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent\Builder
     */
	public function scopeLiveAndVisible($query)
	{
		return $query
			->where('live_at', '<=', Carbon::now())
			->where('hidden', '0')
			->latest();
		}

    /**
     * Scope a query to only include pending appearances.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent\Builder
     */
	public function scopePending($query)
	{
		return $query
			->whereNull('live_at')
			->orWhere('live_at', '>', Carbon::now())
			->latest();
	}

    /**
     * Scope a query to only include hidden appearances.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent\Builder
     */
	public function scopeHidden($query)
	{
		return $query
			->where('live_at', '<=', Carbon::now())
			->where('hidden', '1');
	}

	/**
	* An appearance was created by it's owner.
	*/
	public function owner()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	/**
	* An appearance has a property.
	*/
	public function property()
	{
		return $this->belongsTo('App\Property');
	}

	/**
	* An appearance can have a status.
	*/
	public function status()
	{
		return $this->belongsTo('App\AppearanceStatus', 'status_id');
	}

	/**
	* An appearance belongs to a section.
	*/
	public function section()
	{
		return $this->belongsTo('App\AppearanceSection', 'section_id');
	}

	/**
	* An appearance has many prices.
	*/
	public function prices()
	{
		return $this->hasMany('App\AppearancePrice');
	}

	/**
	 * An appearance can have many features.
	 */
	public function features()
	{
		return $this->hasMany('App\AppearanceFeature');
	}

	/**
	 * Store a price to this appearance.
	 * 
	 * @param  \App\AppearancePrice  $price
	 * @return \App\AppearancePrice
	 */
	public function storePrice(AppearancePrice $price)
	{
		if (!$price->starts_at) {
			$price->starts_at = $this->live_at;
		}
		return $this->prices()->save($price);
	}

	/**
	 * Set the slug for this appearance.
	 * 
	 * @return string
	 */
	public function setSlug()
	{
		$section = $this->section->slug;
		$town = str_slug($this->property->town);
		$address = $this->property->slug;

		$this->slug = $section . '/' . $town . '/' . $address;

		return $this;
	}

}