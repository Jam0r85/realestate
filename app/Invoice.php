<?php

namespace App;

use App\Events\InvoiceItemWasCreated;
use App\Events\InvoicePaymentWasCreated;
use App\InvoiceGroup;
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
    use SoftDeletes,
        Searchable,
        PresentableTrait,
        Filterable;

    /**
     * The presenter for this model
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\InvoicePresenter';

    /**
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    protected $casts = [
        'property_id' => 'integer'
    ];

    /**
     * The attributes that should be eager loaded.
     * 
     * @var array
     */
    protected $with = [
        'invoiceGroup',
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
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            $model->invoice_group_id = get_setting('invoice_default_group');

            if (! $model->invoice_group_id) {
                $invoiceGroup = InvoiceGroup::first();
                $model->invoice_group_id = $invoiceGroup->id;
            } else {
                $invoiceGroup = InvoiceGroup::find($model->invoice_group_id);
            }

            $model->number ?? $model->number = $invoiceGroup->next_number;
            $model->created_at ?? $model->created_at = Carbon::now();
            $model->due_at = Carbon::parse($model->created_at)->addDay(get_setting('invoice_due_after'), 30);
            $model->terms ?? $model->terms = get_setting('invoice_default_terms');
        });

        static::created(function ($model) {
            $model->invoiceGroup->increment('next_number');
        });

        static::deleted(function ($model) {
            if ($model->number == $model->invoiceGroup->next_number - 1) {
                $model->InvoiceGroup->decrement('next_number');
            }
        });
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        $array = $this->only('number','net','tax','total','recipient');

        $array['group'] = $this->invoiceGroup->name;
        $array['created_at'] = date_formatted($this->created_at);

        if ($this->paid_at) {
            $array['paid'] = date_formatted($this->created_at);
        }

        if ($this->property) {
            $array['property'] = $this->property->present()->fullAddress;
        }

        if (count($this->users)) {
            foreach ($this->users as $user) {
                $users[] = $user->present()->name;
            }

            $array['users'] = array_filter($users);
        }

        return $array;
    }

    /**
     * Scope a query to only include paid invoices.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent
     */
    public function scopePaid($query)
    {
        return $query
            ->whereNotNull('paid_at')
            ->latest();
    }

    /**
     * Scope a query to only include unpaid invoices.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent
     */
    public function scopeUnpaid($query)
    {
        return $query
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
     * An invoice belongs to a branch.
     */
    public function branch()
    {
        return $this
            ->property
            ->branch;
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
    	return $this
            ->belongsTo(InvoiceGroup::class);
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
        return $this
            ->morphMany('App\Payment', 'parent');
    }

    /**
     * An invoice can belong to a statement.
     */
    public function statements()
    {
        return $this
            ->belongsToMany('App\Statement');
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
        return $this
            ->hasOne('App\InvoiceRecurring');
    }

    /**
     * An invoice can be created by the recurring generator.
     */
    public function recur()
    {
        return $this
            ->belongsTo('App\InvoiceRecurring');
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
        $this->net = $this->items->sum('net');
        $this->tax = $this->items->sum('tax');
        $this->total = $this->items->sum('total');

        $this->balance = $this->total - ($this->payments->sum('amount') + $this->statementPayments->sum('amount'));

        if ($this->balance <= '0' && count($this->items)) {
            if (is_null($this->paid_at)) {
                if (count($statements = $this->statements()->whereNotNull('paid_at')->get())) {
                    foreach ($statements as $statement) {
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

    /**
     * Has this invoice got no remaining balance?
     * 
     * @return  bool
     */
    public function canBePaid()
    {
        if (! count($this->items)) {
            return false;
        }

        if ($this->hasOutstandingBalance()) {
            return false;
        }

        return true;
    }

    /**
     * Has this invoice been paid?
     * 
     * @return  bool
     */
    public function isPaid()
    {
        if (! $this->paid_at) {
            return false;
        }

        return true;
    }

    /**
     * Has this invoice been sent?
     * 
     * @return  bool
     */
    public function isSent()
    {
        if (!$this->sent_at) {
            return false;
        }

        return true;
    }

    /**
     * Check whether this invoice is overdue.
     * 
     * @return boolean
     */
    public function isOverdue()
    {
        if (! $this->paid_at) {
            return false;
        }

        if (! $this->deleted_at) {
            return false;
        }

        return $this->due_at <= Carbon::now();
    }

    /**
     * Build the correctly formatted recipient for this invoice
     *
     * @return string
     */
    public function buildRecipient($fresh = false)
    {
        /**
         * Check whether we want to start a fresh and replace the existing recipient.
         */
        
        if (! $fresh) {
            $newRecipient = $this->recipient;
        }

        /**
         * Check for linked users and build up an array of user names whilst also
         * getting the home address of the first user found.
         */

        if (count($this->users)) {
            foreach ($this->users as $user) {
                $names[] = $user->present()->fullName;
                // Grab the first home address
                if (!isset($home)) {
                    if ($user->home) {
                        $home = $user->home->present()->letter;
                    }
                }
            }
        }

        return $this->formatRecipient($names, $newRecipient);
    }

    /**
     * Format the recipient address for storing in the text field.
     * 
     * @param  array  $names
     * @param  string  $address
     * @return string
     */
    public function formatRecipient(array $names = [], $address = null)
    {
        if (count($names)) {
            $address = implode(' & ', $names) . '<br />' . $address;
        }

        $address = str_replace('<br />', PHP_EOL, $address);

        return implode(PHP_EOL, array_unique(explode(PHP_EOL, $address)));
    }

    /**
     * Set the recipient.
     *
     * @return $this
     */
    public function setRecipient()
    {
        $this->recipient = $this->buildRecipient();

        return $this;
    }

    /**
     * Check whether this invoice has an outstanding balance.
     * 
     * @return bool
     */
    public function hasOutstandingBalance()
    {
        if ($this->balance > 0) {
            return true;
        }

        return false;
    }
}