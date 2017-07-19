<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends BaseModel
{
    use SoftDeletes;

    /**
     * The attrbites that should be included in the collection.
     * 
     * @var array
     */
    protected $appends = ['total','total_net','total_tax'];
    
    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
	protected $dates = ['due_at','sent_at','paid_at'];

    /**
     * The relations that should be eager leader.
     * 
     * @var array
     */
    protected $with = ['property','users','items'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
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
}