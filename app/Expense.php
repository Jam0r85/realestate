<?php

namespace App;

use App\Document;
use App\Traits\DocumentsTrait;
use Laravel\Scout\Searchable;

class Expense extends BaseModel
{
    use Searchable;
    use DocumentsTrait;

    protected $documentNameType = 'invoice';

    protected $documentPath = 'documents/expenses/';

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        $array = $this->only('name', 'cost', 'created_at', 'paid_at');
        $array['property'] = $this->property->name;
        $array['contractor'] = $this->contractor ? $this->contractor->name : '';

        return $array;
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array'
    ];

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
        'name',
        'cost',
        'paid_at'
    ];

    /**
     * An expense can have a contractor.
     */
    public function contractor()
    {
        return $this->belongsTo('App\User', 'contractor_id');
    }

    /**
     * An expense has one owner.
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * An expense belongs to one property.
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
     * An expense can have many statement payments.
     */
    public function payments()
    {
        return $this->morphMany('App\StatementPayment', 'parent');
    }

    /**
     * Get the expense balance amount.
     *
     * @return int
     */
    public function getRemainingBalanceAttribute()
    {
        return $this->cost - $this->statements->sum('pivot.amount');
    }

    /**
     * Has this expense been paid?
     * 
     * @return boolean
     */
    public function isPaid()
    {
        if ($this->paid_at) {
            return true;
        }

        if ($this->remaining_balance == 0) {
            return true;
        }

        return false;
    }
}
