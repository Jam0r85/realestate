<?php

namespace App;

use App\Branch;
use App\Invoice;
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
	 * An invoice group can have many invoices.
	 */
    public function invoices()
    {
    	return $this
            ->hasMany(Invoice::class)
            ->withTrashed()
            ->latest();
    }

    /**
     * An invoice group can have many paid invoices.
     */
    public function paidInvoices()
    {
        return $this
            ->hasMany(Invoice::class)
            ->with('property','users')
            ->whereNotNull('paid_at')
            ->latest();
    }

    /**
     * An invoice group can have many unpaid invoices.
     */
    public function unpaidInvoices()
    {
        return $this
            ->hasMany(Invoice::class)
            ->with('property','users')
            ->whereNull('paid_at')
            ->latest();
    }

    /**
     * Get the number of paid invoices for this group.
     *
     * @return int
     */
    public function getPaidInvoicesCount()
    {
        return $this->invoices->where('paid_at', '!=', null)->count();
    }

    /**
     * Get the number of unpaid invoices for this group.
     *
     * @return int
     */
    public function getUnpaidInvoicesCount()
    {
        return $this->invoices->where('paid_at', null)->count();
    }

    /**
     * An invoice group belongs to a branch.
     */
    public function branch()
    {
    	return $this
            ->belongsTo(Branch::class);
    }

    /**
     * Store an invoice to this group.
     * 
     * @param  \App\Invoice  $invoice
     * @return \App\Invoice
     */
    public function storeInvoice(Invoice $invoice)
    {
        $this
            ->invoices()
            ->save($invoice);

        return $invoice;
    }
}
