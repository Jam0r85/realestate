<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
    protected $dates = ['paid_at'];

       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'property_id',
		'name',
		'description',
		'cost',
		'paid_at'
	];

	/**
	 * An expense can belong to many contractors.
	 */
    public function contractors()
    {
    	return $this->belongsToMany('App\User');
    }

    /**
     * An expense can have an owner.
     */
    public function owner()
    {
    	return $this->belongsTo('App\User');
    }

    /**
     * An expense can belong to a property.
     */
    public function property()
    {
    	return $this->belongsTo('App\Property');
    }

    /**
     * An expense can belong to many statements.
     */
    public function statements()
    {
    	return $this->belongsToMany('App\Statement')
    		->withPivot('amount');
    }

    /**
     * Get the expenses' statement name.
     * 
     * @return string
     */
    public function getStatementNameAttribute()
    {
        $name = '<b>' . $this->name . '</b>';

        if (count($this->contractors)) {
            $name .= '<br />';
            foreach ($this->contractors as $user) {
                $name .= $user->name;
            }
        }

        return $name;
    }
}
