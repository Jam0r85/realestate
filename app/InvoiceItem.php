<?php

namespace App;

class InvoiceItem extends BaseModel
{
    /**
     * The attrbites that should be included in the collection.
     * 
     * @var array
     */
    protected $appends = ['total','total_net','total_tax'];

    /**
     * The relations that should be eager leader.
     * 
     * @var array
     */
    protected $with = ['taxRate'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'invoice_id',
		'name',
		'description',
		'amount',
		'quantity',
		'tax_rate_id'
	];

	/**
	 * An invoice item belongs to an invoice.
	 */
    public function invoice()
    {
    	return $this->belongsTo('App\Invoice');
    }

    /**
     * An invoice item can have a tax rate.
     */
    public function taxRate()
    {
    	return $this->belongsTo('App\TaxRate');
    }

    /**
     * Get the invoice item's total tax cost.
     * 
     * @return integer
     */
    public function getTotalTaxAttribute()
    {
        if (!$this->taxRate) {
            return 0;
        }

        return ($this->taxRate->amount / 100) * $this->total_net;
    }

    /**
     * Get an invoice item's net cost.
     * 
     * @return integer
     */
    public function getTotalNetAttribute()
    {
        return $this->amount * $this->quantity;
    }

    /**
     * Get the invoice item's total cost.
     * 
     * @return integer
     */
    public function getTotalAttribute()
    {
        return $this->total_net + $this->total_tax;
    }
}
