<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceGroup extends BaseModel
{   
    Use SoftDeletes;

    /**
     * The attrbites that should be included in the collection.
     * 
     * @var array
     */
    protected $appends = ['invoices_total'];
    
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
    	return $this->hasMany('App\Invoice')->latest();
    }

    /**
     * An invoice group belongs to a branch.
     */
    public function branch()
    {
    	return $this->belongsTo('App\Branch');
    }

    /**
     * Get the total income from paid invoices for this group.
     * 
     * @return integer
     */
    public function getInvoicesTotalAttribute()
    {
        return $this->invoices()->whereNotNull('paid_at')->get()->sum('total');
    }
}
