<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Statement extends BaseModel
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
    protected $dates = ['period_start','period_end','paid_at','sent_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'tenancy_id',
		'key',
		'period_start',
		'period_end',
		'amount',
		'paid_at',
		'sent_at'
	];

	/**
	 * A statement can belong to a tenancy.
	 */
	public function tenancy()
	{
		return $this->belongsTo('App\Tenancy');
	}

	/**
	 * A statement can belong to a property through it's tenancy.
	 */
	public function property()
	{
		return $this->tenancy->property;
	}

	/**
	 * A statement can belong to many users.
	 */
    public function users()
    {
    	return $this->belongsToMany('App\User');
    }

    /**
     * A statement can belong to many invoices.
     */
    public function invoices()
    {
        return $this->belongsToMany('App\Invoice');
    }

    /**
     * A statement can have many payments out to landlords, contractors, etc.
     */
    public function payments()
    {
        return $this->hasMany('App\StatementPayment');
    }

    /**
     * A statement can have many expenses.
     */
    public function expenses()
    {
        return $this->belongsToMany('App\Expense')
            ->withPivot('amount');
    }

    /**
     * Get the statement name.
     * 
     * @return [type] [description]
     */
    public function getNameAttribute()
    {
    	return date_formatted($this->period_start) . ' - ' . date_formatted($this->period_end);
    }

    /**
     * Get the statement's property.
     * 
     * @return \App\Property
     */
    public function getPropertyAttribute()
    {
    	return $this->property();
    }

    /**
     * Get the statement's invoice.
     * 
     * @return \App\Invoice
     */
    public function getInvoiceAttribute()
    {
        return $this->invoices()->first();
    }

    /**
     * Get the statement's invoice total.
     * 
     * @return int
     */
    public function getInvoiceTotalAmountAttribute()
    {
        return $this->invoice ? $this->invoice->total : 0;
    }

    /**
     * Get the statement's expense total
     * 
     * @return int
     */
    public function getExpenseTotalAmountAttribute()
    {
        return $this->expenses->sum('pivot.amount');
    }

    /**
     * Get the statement's balance amount to the landlord.
     * 
     * @return int
     */
    public function getLandlordBalanceAmountAttribute()
    {
        return $this->amount - ($this->invoice_total_amount + $this->expense_total_amount);
    }

    /**
     * Get the statement's net amount.
     * 
     * @return int
     */
    public function getNetAmountAttribute()
    {
        return $this->expense_total_amount + $this->invoices->sum('total_net');
    }

    /**
     * Get the statement's net amount.
     * 
     * @return int
     */
    public function getTaxAmountAttribute()
    {
        return $this->invoices->sum('total_tax');
    }

    /**
     * Get the statement's net amount.
     * 
     * @return int
     */
    public function getTotalAmountAttribute()
    {
        return $this->net_amount + $this->tax_amount;
    }

    /**
     * Get the recipient of the rental statement.
     * 
     * @return string
     */
    public function getRecipientAttribute()
    {
        return $this->users()->first()->home_formatted;
    }

    /**
     * Check whether a statement has an invoice.
     * 
     * @return bool
     */
    public function hasInvoice()
    {
        return (boolean) $this->invoices()->first();
    }

    /**
     * Check whether a statement has unsent payments.
     * 
     * @return int
     */
    public function hasUnsentPayments()
    {
        return $this->payments()->whereNull('sent_at')->count();
    }

    /**
     * Are we posting this rental statement instead of sending it by email?
     * 
     * @return bool
     */
    public function sendByPost()
    {
        return $this->property->hasSetting('post_rental_statement');
    }
}
