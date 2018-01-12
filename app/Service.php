<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

class Service extends BaseModel
{
    use PresentableTrait,
        SoftDeletes;

    /**
     * The presenter for this model.
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\ServicePresenter';

    public $casts = [
        'is_percent' => 'boolean'
    ];

	/**
	 * The attrbites that should be included in the collection.
	 * 
	 * @var array
	 */
	protected $appends = ['charge_formatted'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'charge',
        'letting_fee',
        're_letting_fee',
        'tax_rate_id'
    ];

	/**
	 * A service can have a tax rate.
	 */
    public function taxRate()
    {
    	return $this
            ->belongsTo('App\TaxRate')
            ->withTrashed();
    }

    /**
     * Get the monthly charge for this service.
     * 
     * @return int
     */
    public function getChargePerMonth()
    {
        if ($this->is_percent) {
            return $this->charge / 100;
        }

        return $this->charge;
    }

    /**
     * Set the slug name for this service.
     *
     * @param  string  $value
     * @return  void
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value);
    }
}
