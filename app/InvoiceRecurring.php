<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class InvoiceRecurring extends Model
{
    /**
     * The table associated with the model
     *
     * @var  string
     */
    protected $table = 'invoice_recurring';

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
    protected $dates = ['next_invoice','ends_at'];

    /**
     * A recurring invoice belongs to an owner.
     */
    public function owner()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * A recurring invoice belongs to an invoice.
     */
    public function invoice()
    {
    	return $this->belongsTo('App\Invoice');
    }

    /**
     * Scope a query to only include the next invoice due.
     * 
     * @param \Illuminate\Database\Eloquent\Builer $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInvoiceDue($query)
    {
        return $query->where('next_invoice', '<=', Carbon::now());
    }
}
