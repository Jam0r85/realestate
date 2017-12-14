<?php

namespace App;

use App\Events\InvoiceItemWasCreated;
use App\Events\InvoicePaymentWasCreated;
use App\InvoiceItem;
use App\Jobs\SendInvoiceToUsers;
use App\Payment;
use App\StatementPayment;
use Carbon\Carbon;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use Laravel\Scout\Searchable;

class Invoice extends PdfModel
{
    use SoftDeletes;
    use Searchable;
    use PresentableTrait;
    use Filterable;

    /**
     * The presenter for this model
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\InvoicePresenter';

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        // Filter the model.
        $array = $this->only('number','created_at','paid_at');

        // Get the property name.
        if ($this->property) {
            $array['property'] = $this->property->name;
        }

        // Get the recipient of the invoice.
        $array['recipient'] = $this->recipient;

        // Get the attached users to the invoice.
        $array['users'] = count($this->users) ? $this->users->pluck('name')->toArray() : null;

        // Get the amounts of the invoice.
        $array['amount'] = [
            'total' => $this->total,
            'net' => $this->total_net,
            'tax' => $this->total_tax
        ];

        // Get the item names and descriptions.
        $array['items'] = count($this->items) ? $this->items->pluck('name','description')->toArray() : null;

        return $array;
    }

    /**
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    protected $casts = [
        'property_id' => 'integer'
    ];
    
    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
	protected $dates = ['due_at','sent_at','paid_at','deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
        'user_id',
		'property_id',
		'invoice_group_id',
		'number',
		'recipient',
		'net',
		'tax',
		'total',
        'balance',
		'terms',
		'key',
		'due_at',
		'sent_at',
		'paid_at'
	];

    /**
     * Scope a query to only include paid invoices.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent
     */
    public function scopePaid($query)
    {
        return $query
            ->with('invoiceGroup','property','users','items','items.taxRate','statement_payments','statements')
            ->whereNotNull('paid_at')
            ->latest();
    }

    /**
     * Scope a query to only include unpaid invoices.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent
     */
    public function scopeUnpaid($query)
    {
        return $query
            ->with('invoiceGroup','property','users','items','items.taxRate','statement_payments','statements')
            ->whereNull('paid_at')
            ->latest();
    }

	/**
	 * An invoice can belong to an owner.
	 */
	public function owner()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	/**
	 * An invoice belongs to a property.
	 */
    public function property()
    {
    	return $this->belongsTo('App\Property')->withTrashed();
    }

    /**
     * An invoice belongs to an invoice group.
     */
    public function invoiceGroup()
    {
    	return $this->belongsTo('App\InvoiceGroup');
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
        return $this
            ->hasMany('App\InvoiceItem');
    }

    /**
     * An invoice can have many payments.
     */
    public function payments()
    {
        return $this->morphMany('App\Payment', 'parent');
    }

    /**
     * An invoice can belong to a statement.
     */
    public function statements()
    {
        return $this->belongsToMany('App\Statement');
    }

    /**
     * An invoice can have many statement payments.
     */
    public function statementPayments()
    {
        return $this
            ->morphMany('App\StatementPayment', 'parent');
    }

    /**
     * An invoice can have many sent statement payments.
     */
    public function statementPaymentsSent()
    {
        return $this
            ->morphMany('App\StatementPayment', 'parent')
            ->whereNotNull('sent_at');
    }

    /**
     * An invoice may have one recurring.
     */
    public function recurring()
    {
        return $this->hasOne('App\InvoiceRecurring');
    }

    /**
     * An invoice can be created by the recurring generator.
     */
    public function recur()
    {
        return $this->belongsTo('App\InvoiceRecurring', 'recur_id');
    }

    /**
     * Get the name of this invoice.
     * 
     * @return string
     */
    public function getNameAttribute()
    {
        return str_replace('{{number}}', $this->number, $this->invoiceGroup->format);
    }

    /**
     * Set the invoice's recipient.
     * 
     * @param string $value
     */
    public function setRecipientAttribute($value)
    {
        $this->attributes['recipient'] = $value ? encrypt($value) : null;
    }

    /**
     * Get the invoice's recipient.
     * 
     * @param  string $value
     * @return string
     */
    public function getRecipientAttribute($value)
    {
        return $value ? decrypt($value) : null;
    }

    /**
     * Get the invoice recipient formatted.
     * 
     * @return string
     */
    public function getRecipientFormattedAttribute()
    {
        if ($this->recipient) {
            return nl2br($this->recipient);
        }

        if (count($this->users)) {
            foreach ($this->users as $user) {
                if ($user->home) {
                    return $user->home->name_formatted;
                }
            }
        }
    }

    /**
     * Store an invoice item to an invoice.
     * 
     * @param \App\InvoiceItem $item
     * @return void
     */
    public function storeItem(InvoiceItem $item)
    {
        $this->items()->save($item);

        event (new InvoiceItemWasCreated($item));
        
        return $item;
    }

    /**
     * Clone this invoice and give it a new number.
     * 
     * @return \App\Invoice
     */
    public function clone($attributes = [])
    {
        $new = $this->replicate();
        $new->paid_at = null;
        $new->number = $this->invoiceGroup->next_number;

        if (count($attributes)) {
            foreach ($attributes as $name => $value) {
                $new->$name = $value;
            }
        }

        $new->save();

        $new->users()->sync($this->users);

        foreach ($this->items as $item) {
            $new_item = $item->replicate();
            $new_item->invoice_id = $new->id;
            $new_item->save();
        }

        return $new;
    }

    /**
     * Store an statement payment to this invoice.
     * 
     * @param  \App\StatementPayment  $payment
     * @return \App\StatementPayment
     */
    public function storeStatementPayment(StatementPayment $payment)
    {
        $this->statement_payments()->save($payment);
        $payment->users()->attach($this->property->owners);

        return $payment;
    }

    /**
     * Store a payment to this invoice.
     * 
     * @param  \App\Payment  $payment
     * @return \App\Payment
     */
    public function storePayment(Payment $payment)
    {
        $this->payments()->save($payment);

        $payment
            ->users()
            ->attach($this->users);

        event(new InvoicePaymentWasCreated($payment));

        return $payment;
    }

    /**
     * Send this invoice to it's users.
     * 
     * @return void
     */
    public function send()
    {
        SendInvoiceToUsers::dispatch($this);

        // Update this statement sent_at date.
        $this->update([
            'sent_at' => Carbon::now()
        ]);
    }

    /**
     * Update the balances for this invoice.
     * 
     * @return void
     */
    public function updateBalances()
    {
        $this->net = $this->present()->itemsTotalNet;
        $this->tax = $this->present()->itemsTotalTax;
        $this->total = $this->present()->itemsTotal;
        $this->balance = $this->present()->remainingBalanceTotal;

        if (empty($this->balance) && count($this->items)) {
            if (!$this->paid_at) {
                if (count($this->statements)) {
                    foreach ($this->statements as $statement) {
                        $this->paid_at = $statement->paid_at;
                    }
                } else {
                    $this->paid_at = Carbon::now();
                }
            }
        } else {
            $this->paid_at = null;
        }

        $this->saveWithMessage('balances updated');
    }
}