<?php

namespace App;

use Carbon\Carbon;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

class Agreement extends BaseModel
{
    use SoftDeletes,
        PresentableTrait,
        Filterable;

    /**
     * The presenter for this model.
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\AgreementPresenter';

    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
    protected $dates = ['starts_at','ends_at'];

	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array
	 */
    protected $fillable = [
        'starts_at',
        'length',
        'ends_at'
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
            $model->ends_at = calculate_end_date($model->starts_at, $model->length);
        });
    }

    /**
     * An agreement belongs to a tenancy.
     */
    public function tenancy()
    {
    	return $this->belongsTo('App\Tenancy');
    }

   	/**
   	 * An agreement was created by a user.
   	 */
    public function owner()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get the agreement status.
     * 
     * @return string
     */
    public function getStatusFormatted()
    {
    	if ($this->starts_at > Carbon::now()) {
    		return 'Pending';
    	}

    	if (!is_null($this->ends_at) && $this->ends_at <= Carbon::now()) {
    		return 'Ended';
    	}

    	return 'Active';
    }

    /**
     * Get the agreement ends_at field but format it.
     * 
     * @return string
     */
    public function getEndsAtFormattedAttribute()
    {
    	if ($this->ends_at) {
    		return date_formatted($this->ends_at);
    	}

    	return 'n/a';
    }

    /**
     * Get the agreement length but format it.
     * 
     * @return string
     */
    public function getLengthFormattedAttribute()
    {
    	$parts = explode('-', $this->length);

    	if ($parts[0] > 0) {
    		return $parts[0] . ' ' . $parts[1];
    	}

    	return 'SPT';
    }
    
    /**
     * Set the agreement's length.
     * 
     * @param string $value
     * @return void
     */
    public function setLengthAttribute($value)
    {
        $this->attributes['length'] = str_slug($value);
    }
}