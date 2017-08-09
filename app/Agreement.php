<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agreement extends BaseModel
{
	use SoftDeletes;

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
    protected $fillable = ['user_id','tenancy_id','starts_at','length','ends_at'];

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
    	return $this->belongsTo('App\User');
    }

    /**
     * Get the agreement status.
     * 
     * @return string
     */
    public function getStatusFormatted()
    {
    	if ($this->starts_at > Carbon::now()) {
    		return 'Proposed';
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

    public static function createAgreement(array $data)
    {
        // Calculate the end date provding it hasn't already been set.
        if (!isset($data['ends_at'])) {

            list($number, $length) = explode('-', $data['length']);

            if ($number == 0) {
                $data['ends_at'] = null;
            }

            if ($number > 0) {
                $data['ends_at'] = clone $data['starts_at'];
                $data['ends_at']->addMonth($number)->subDay();
            }
        }

        // Create the statement
        return parent::create($data);
    }
}
