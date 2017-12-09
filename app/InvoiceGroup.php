<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceGroup extends BaseModel
{   
    Use SoftDeletes;
    
	/**
	 * Indicates if the model should be timestamped.
	 * 
	 * @var bool
	 */
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $fillable = ['name','next_number','format','branch_id'];
	
	/**
	 * An invoice group has many invoices.
	 */
    public function invoices()
    {
    	return $this->hasMany('App\Invoice')
            ->latest();
    }

    /**
     * An invoice group can have many unpaid invoices.
     */
    public function unpaidInvoices()
    {
        return $this->hasMany('App\Invoice')
            ->whereNull('paid_at')
            ->latest();
    }

    /**
     * An invoice group belongs to a branch.
     */
    public function branch()
    {
    	return $this->belongsTo('App\Branch');
    }

    /**
     * Store an invoice to this group.
     * 
     * @param  \App\Invoice  $invoice
     * @return  \App\Invoice
     */
    public function storeInvoice(Invoice $invoice)
    {
        $this->invoices()->save($invoice);

        return $invoice;
    }
}
