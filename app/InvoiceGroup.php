<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceGroup extends BaseModel
{   
    Use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'name',
        'next_number',
        'format',
        'branch_id'
    ];
    
	/**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = str_slug($model->name);
        });
    }
	
	/**
	 * An invoice group has many invoices.
	 */
    public function invoices()
    {
    	return $this
            ->hasMany('App\Invoice')
            ->latest();
    }

    /**
     * An invoice group belongs to a branch.
     */
    public function branch()
    {
    	return $this
            ->belongsTo('App\Branch');
    }

    /**
     * Store an invoice to this group.
     * 
     * @param  \App\Invoice  $invoice
     * @return \App\Invoice
     */
    public function storeInvoice(Invoice $invoice)
    {
        $invoice->number ?? $invoice->number = $this->next_number;

        $this
            ->invoices()
            ->save($invoice);

        $this->increment('next_number');

        return $invoice;
    }
}
