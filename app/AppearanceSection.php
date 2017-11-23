<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppearanceSection extends Model
{
	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array
	 */
	protected $fillable = ['name'];

    /**
     * Set the appearance sections slug.
     * 
     * @param  string  $value
     * @return  void
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value);
    }

    /**
     * A section may have it's own statuses.
     */
    public function statuses()
    {
        return $this->hasMany('App\AppearanceStatus');
    }

    /**
     * A section many have it's own price qualifiers.
     */
    public function qualifiers()
    {
        return $this->hasMany('App\AppearancePriceQualifiers');
    }

	/**
	 * A section can have many appearances.
	 */
    public function appearances()
    {
    	return $this->hasMany('App\Appearance')
            ->withTrashed()
    		->latest();
    }

    /**
     * A section can have many live appearances.
     */
    public function liveAppearances()
    {
    	return $this->hasMany('App\Appearance')
    		->latest();
    }

       /**
     * A section can have many hidden appearances.
     */
    public function hiddenAppearances()
    {
    	return $this->hasMany('App\Appearance')
    		->where('hidden', true)
    		->latest();
    }
}
