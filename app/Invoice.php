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
	protected $dates = ['due_at','sent_at','paid_at'];

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
		return $this->belongsTo('App\User');
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
    public function group()
    {
    	return $this->belongsTo('App\InvoiceGroup');
    }

    /**
     * An invoice belongs to a branch through it's invoice group.
     */
    public function branch()
    {
    	return $this->belongsToThrough('App\Branch', 'App\InvoiceGroup');
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
        return $value ? decrypt($value) : $value;
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
     * Get the invoice's full recipient including the users and the address.
     * 
     * @return string
     */
    public function getRecipientFullAttribute()
    {
        return $this->recipient;
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