<?php

namespace App;

use App\Document;
use App\StatementPayment;
use App\Traits\DocumentsTrait;
use EloquentFilter\Filterable;
use Laracasts\Presenter\PresentableTrait;
use Laravel\Scout\Searchable;

class Expense extends BaseModel
{
    use Searchable;
    use DocumentsTrait;
    use PresentableTrait;
    use Filterable;

    /**
     * The presenter for this model.
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\ExpensePresenter';

    /**
     * The document name type.
     * 
     * @var string
     */
    protected $documentNameType = 'invoice';

    /**
     * The base path to the document storage for this model.
     * 
     * @var string
     */
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
        'paid_at',
        'contractor_id',
        'property_id'
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
     * Store a payment against this expense.
     * 
     * @param \App\StatementPayment $payment
     * @return void
     */
    public function storePayment(StatementPayment $payment)
    {
        $this->payments()->save($payment);
        $payment->users()->attach($this->contractor);
    }
}
