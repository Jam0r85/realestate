<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

class Service extends BaseModel
{
    use PresentableTrait;
    use SoftDeletes;

    /**
     * The presenter for this model.
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\ServicePresenter';

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
     * Get the service's charge formatted.
     * 
     * @return string
     */
    public function getChargeFormattedAttribute()
    {
    	if ($this->charge < 1) {
    		return $this->charge * 100 . '%';
    	} else {
    		return currency($this->charge);
    	}
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
