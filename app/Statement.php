<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
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
     * @return integer
     */
    public function getInvoiceTotalAmountAttribute()
    {
        return $this->invoice ? $this->invoice->total : 0;
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
     * @return boolean
     */
    public function hasInvoice()
    {
        return (boolean) $this->invoices()->first();
    }
}
