<?php

namespace App;

use App\Invoice;
use App\TaxRate;
use Laracasts\Presenter\PresentableTrait;

class InvoiceItem extends BaseModel
{
    use PresentableTrait;

    /**
     * The presenter for this model
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\InvoicePresenter';

    /**
     * The attrbites that should be included in the collection.
     * 
     * @var array
     */
    protected $appends = ['total','net','tax'];

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
    	return $this
            ->belongsTo(Invoice::class)
            ->withTrashed();
    }

    /**
     * Set the amount of this invoice item.
     * 
     * @param  integer  $value
     * @return void
     */
    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = pounds_to_pence($value);
    }

    /**
     * An invoice item can have a tax rate.
     */
    public function taxRate()
    {
    	return $this
            ->belongsTo(TaxRate::class)
            ->withTrashed();
    }

    /**
     * Get an invoice item's net cost.
     * 
     * @return integer
     */
    public function getNetAttribute()
    {
        return $this->amount * $this->quantity;
    }

    /**
     * Get the invoice item's total tax cost.
     * 
     * @return integer
     */
    public function getTaxAttribute()
    {
        return calculateTax($this->net, $this->taxRate);
    }

    /**
     * Get the invoice item's total cost.
     * 
     * @return integer
     */
    public function getTotalAttribute()
    {
        return $this->net + $this->tax;
    }
}
