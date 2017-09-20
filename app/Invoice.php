<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Invoice extends BaseModel
{
    use SoftDeletes;
    use Searchable;

    /**
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    protected $casts = [
        'property_id' => 'integer'
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        // Filter the model.
        $array = $this->only('number');

        // Get the dates.
        $array['dates'] = [
            'created_at' => $this->created_at,
            'paid' => $this->paid_at
        ];

        // Get the property name.
        if ($this->property) {
            $array['property'] = $this->property->name;
        }

        // Get the recipient of the invoice.
        $array['recipient'] = $this->recipient;

        // Get the attached users to the invoice.
        $array['users'] = count($this->users) ? $this->users->pluck('name')->toArray() : null;

        // Get the amounts of the invoice.
        $array['amount'] = [
            'total' => $this->total,
            'net' => $this->total_net,
            'tax' => $this->total_tax
        ];

        // Get the item names and descriptions.
        $array['items'] = count($this->items) ? $this->items->pluck('name','description')->toArray() : null;

        return $array;
    }

    /**
     * The attrbites that should be included in the collection.
     * 
     * @var array
     */
    protected $appends = [
        'total',
        'total_net',
        'total_tax',
        'total_payments',
        'total_balance',
        'recipient_full'
    ];
    
    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
	protected $dates = ['due_at','sent_at','paid_at','deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
        'user_id',
		'property_id',
		'invoice_group_id',
		'number',
		'recipient',
		'net',
		'tax',
		'total',
		'terms',
		'key',
		'due_at',
		'sent_at',
		'paid_at'
	];

	/**
	 * An invoice can belong to an owner.
	 */
	public function owner()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	/**
	 * An invoice belongs to a property.
	 */
    public function property()
    {
    	return $this->belongsTo('App\Property');
    }

    /**
     * An invoice belongs to an invoice group.
     */
    public function invoiceGroup()
    {
    	return $this->belongsTo('App\InvoiceGroup');
    }

    /**
     * An invoice can belong to many users.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * An invoice can have many items.
     */
    public function items()
    {
        return $this->hasMany('App\InvoiceItem');
    }

    /**
     * An invoice can have many payments.
     */
    public function payments()
    {
        return $this->morphMany('App\Payment', 'parent');
    }

    /**
     * An invoice can belong to a statement.
     */
    public function statements()
    {
        return $this->belongsToMany('App\Statement');
    }

    /**
     * An invoice can have many statement payments.
     */
    public function statement_payments()
    {
        return $this->morphMany('App\StatementPayment', 'parent');
    }

    /**
     * Set the invoice's recipient.
     * 
     * @param string $value
     */
    public function setRecipientAttribute($value)
    {
        $this->attributes['recipient'] = $value ? encrypt($value) : null;
    }

    /**
     * Get the invoice's recipient.
     * 
     * @param  string $value
     * @return string
     */
    public function getRecipientAttribute($value)
    {
        if ($value) {
            return decrypt($value);
        }

        if (count($this->users)) {
            foreach ($this->users as $user) {
                if ($user->home) {
                    return $user->home->name_formatted;
                }
            }
        }
    }

    /**
     * Get the invoice's total cost.
     * 
     * @return integer
     */
    public function getTotalAttribute()
    {
        return $this->items->sum('total');
    }

    /**
     * Get the invoice's total net cost.
     * 
     * @return integer
     */
    public function getTotalNetAttribute()
    {
        return $this->items->sum('total_net');
    }

    /**
     * Get the invoice's total tax cost.
     * 
     * @return integer
     */
    public function getTotalTaxAttribute()
    {
        return $this->items->sum('total_tax');
    }

    /**
     * Get the invoice's total payments amount.
     * 
     * @return integer
     */
    public function getTotalPaymentsAttribute()
    {
        return $this->payments->sum('amount') + $this->statement_payments->sum('amount');
    }

    /**
     * Get the invoice's total balance remaining amount.
     * 
     * @return integer
     */
    public function getTotalBalanceAttribute()
    {
        return $this->total - $this->total_payments;
    }

    /**
     * Get the invoice's statement.
     * 
     * @return \App\Invoice
     */
    public function getStatementAttribute()
    {
        return $this->statements()->first();
    }

    /**
     * Check wherther this invoice belongs to a statement.
     * 
     * @return boolean
     */
    public function hasStatement()
    {
        return (boolean) $this->statements()->first();
    }

    /**
     * Check whether the invoice can accept new payments or not.
     * 
     * @return bool
     */
    public function canTakePayments()
    {
        if ($this->total_balance > 0) {
            return true;
        }

        return false;
    }
}