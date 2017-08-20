<?php

namespace App;

use Laravel\Scout\Searchable;

class Expense extends BaseModel
{
    use Searchable;

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        return $array;
    }

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
     * An expense can have many documents.
     */
    public function invoices()
    {
        return $this->morphMany('App\Document', 'parent');
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
     * An expense can have many payments.
     */
    public function payments()
    {
        return $this->morphMany('App\StatementPayment', 'parent');
    }

    /**
     * Get the expense balance amount.
     * 
     * @return integer
     */
    public function getBalanceAmountAttribute()
    {
        return $this->cost - $this->statements->sum('pivot.amount');
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

    /**
     * Does this expense have an invoice?
     * 
     * @return bool
     */
    public function hasInvoice()
    {

    }
}
