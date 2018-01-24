<?php

namespace App;

use App\Expense;
use App\Invoice;
use App\InvoiceItem;
use App\Notifications\StatementSentByEmailToLandlordNotification;
use App\Notifications\StatementSentByPostToLandlordNotification;
use App\StatementPayment;
use Carbon\Carbon;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Notification;
use Laracasts\Presenter\PresentableTrait;
use Laravel\Scout\Searchable;

class Statement extends PdfModel
{
    use Searchable;
    use SoftDeletes;
    use PresentableTrait;
    use Filterable;

    /**
     * The presenter for this model.
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\StatementPresenter';

    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
    protected $dates = ['deleted_at','period_start','period_end','paid_at','sent_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'tenancy_id',
		'key',
        'send_by',
		'period_start',
		'period_end',
		'amount',
		'paid_at',
		'sent_at',
        'created_at'
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
            $model->send_by = $model->tenancy->property->getSetting('statement_send_method') ?? 'email';
            $model->period_end ?? $model->period_end = $model->period_start->addMonth()->subDay();
            $model->amount ?? $model->amount = $model->tenancy->present()->rentAmountPlain;
        });

        static::deleted(function ($model) {
            if ($model->forceDeleting) {
                $model->payments()->whereNotNull('sent_at')->delete();
                $model->payments()->whereNull('sent_at')->delete();
                $model->invoices()->forceDelete();
            }
        });
    }

    /**
     * Set the amount of this statement.
     * 
     * @param  integer  $value
     * @return void
     */
    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = pounds_to_pence($value);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        $array = $this->only('amount','period_start','period_end','sent_at','paid_at');
        $array['property'] = $this->tenancy->property->present()->fullAddress;
        $array['tenancy'] = $this->tenancy->present()->name;
        $array['amount'] = $this->amount;

        return $array;
    }
    
	/**
	 * A statement can belong to a tenancy.
	 */
	public function tenancy()
	{
		return $this
            ->belongsTo('App\Tenancy')
            ->withTrashed();
	}

	/**
	 * A statement can belong to a property through it's tenancy.
	 */
	public function property()
	{
		return $this->tenancy->property;
	}

	/**
	 * A statement can belong to many users.
	 */
    public function users()
    {
    	return $this
            ->belongsToMany('App\User');
    }

    /**
     * A statement can have an owner.
     */
    public function owner()
    {
        return $this
            ->belongsTo('App\User', 'user_id');
    }

    /**
     * A statement belongs to a branch.
     */
    public function branch()
    {
        return $this
            ->tenancy
            ->property
            ->branch;
    }

    /**
     * A statement can belong to many invoices.
     */
    public function invoices()
    {
        return $this
            ->belongsToMany(Invoice::class);
    }

    /**
     * A statement can have many payments out to landlords, contractors, etc.
     */
    public function payments()
    {
        return $this
            ->hasMany(StatementPayment::class);
    }

    /**
     * A statement can have many sent payments.
     */
    public function sentPayments()
    {
        return $this
            ->hasMany(StatementPayment::class)
            ->whereNotNull('sent_at');
    }

    /**
     * A statement can have unsent payments
     */
    public function unsentPayments()
    {
        return $this
            ->hasMany(StatementPayment::class)
            ->whereNull('sent_at');
    }

    /**
     * A statement can have many expenses with an amount paid.
     */
    public function expenses()
    {
        return $this
            ->belongsToMany('App\Expense')
            ->withPivot('amount');
    }

    /**
     * Get the statement's bank account.
     */
    public function getBankAccountAttribute()
    {
        return $this->property()->bank_account;
    }

    /**
     * Create a new statement for a given tenancy.
     * 
     * @param array $data
     * @param integer $id
     * @return \App\Statement
     */
    public static function createFromTenancy(array $data, $tenancy_id)
    {
        $statement = parent::create($data);
        return $statement;
    }

    /**
     * Store an invoice to this statement and attach the property owners to the invoice.
     * 
     * @param  \App\Invoice  $invoice
     * @return \App'Invoice
     */
    public function storeInvoice(Invoice $invoice)
    {
        $this->invoices()->save($invoice);
        $invoice->users()->sync($this->property()->owners);

        $this->createInvoiceLettingItem($invoice);
        $this->createInvoiceReLettingItem($invoice);
        $this->createInvoiceManagementItem($invoice);

        return $invoice;
    }

    /**
     * Attach an expense to this statement.
     * 
     * @param  \App\Expense  $expense  the expense that we are attaching
     * @param  integer  $amount  the amount we are paying towards the expense
     * @return  \App\Expense
     */
    public function attachExpense(Expense $expense, $amount = null)
    {
        if (is_null($amount)) {
            $amount = $expense->cost;
        }

        return $this->expenses()->attach($expense, ['amount' => $amount]);
    }

    /**
     * Send this statement to it's owners by running the SendStatementToOwners job.
     */
    public function send()
    {
        // Send the statement by E-Mail
        if ($this->send_by == 'email') {
            Notification::send($this->users, new StatementSentByEmailToLandlordNotification($this));
        }

        // Send the statement by Post
        if ($this->send_by == 'post') {
            Notification::send($this->users, new StatementSentByPostToLandlordNotification($this));
        }

        // Update the statement as having been sent
        if (!$this->sent_at) {
            $this->sent_at = Carbon::now();
            $this->saveWithMessage('has been dispatched');
        }

        return $this;
    }

    /**
     * Check whether this statement needs an invoice as well.
     * 
     * @return  boolean
     */
    public function needsInvoiceCheck()
    {
        if ($this->tenancy->getLettingFeeWithCustom() > 0) {
            return true;
        }

        if ($this->tenancy->getReLettingFeeWithCustom() > 0) {
            return true;
        }

        if ($this->tenancy->getServiceChargeNetAmount() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Create the invoice management item.
     * 
     * @return void
     */
    public function createInvoiceReLettingItem(Invoice $invoice)
    {
        $tenancy = $this->tenancy;
        $service = $tenancy->service;
        $property = $tenancy->property;

        if ($service) {

            // Other tenancies already exist
            if (count($property->tenancies) > 1) {

                // Is this the first statement for this tenancy?
                if (count($tenancy->statements) == 1) {

                    // Set the re-letting fee from the service
                    $amount = $tenancy->getReLettingFeeWithCustom();

                    // Is the letting fee a valid amount?
                    if ($amount > 0) {

                        $item = new InvoiceItem();
                        $item->name = $service->name;
                        $item->description = $service->name . ' Re-Letting Fee';
                        $item->amount = $amount;
                        $item->quantity = 1;
                        $item->tax_rate_id = $service->tax_rate_id;

                        $invoice->storeItem($item);
                    }
                }
            }
        }
    }

    /**
     * Create the invoice letting item.
     * 
     * @return void
     */
    public function createInvoiceLettingItem(Invoice $invoice)
    {
        $tenancy = $this->tenancy;
        $service = $tenancy->service;
        $property = $tenancy->property;

        // Make sure we have a valid service first
        if ($service) {

            // First tenancy for the property?
            if (count($property->tenancies) == 1) {

                // Is this the first statement for this tenancy?
                if (count($tenancy->statements) == 1) {

                    $amount = $tenancy->getLettingFeeWithCustom();

                    // Is the letting fee a valid amount?
                    if ($amount > 0) {

                        $item = new InvoiceItem();
                        $item->name = $service->name;
                        $item->description = $service->name . ' Letting Fee';
                        $item->amount = $amount;
                        $item->quantity = 1;
                        $item->tax_rate_id = $service->tax_rate_id;

                        $invoice->storeItem($item);
                    }
                }
            }
        }
    }

    /**
     * Create the invoice re-letting item.
     * 
     * @return void
     */
    public function createInvoiceManagementItem(Invoice $invoice)
    {
        $tenancy = $this->tenancy;
        $service = $tenancy->service;

        // Do we have a valid service charge amount?
        if ($charge = $tenancy->getServiceChargeNetAmount()) {

            // Format the description
            $description = $service->name . ' service at ' . $service->present()->monthlyChargeFormatted;

            // If there is a tax rate add it to the description as well
            if ($service->taxRate) {
                $description .= ' plus ' . $service->taxRate->name;
            }

            // Loop through each of the current invoice items and check for duplicates
            foreach ($invoice->items as $item) {
                if ($item->description == $description) {
                    return;
                }
            }

            $item = new InvoiceItem();
            $item->name = $service->name;
            $item->description = $description;
            $item->amount = pence_to_pounds($charge);
            $item->quantity = 1;
            $item->tax_rate_id = $service->tax_rate_id;

            $invoice->storeItem($item);
        }
    }

    /**
     * Check whether this statement can be sent.
     * 
     * @return  bool
     */
    public function canBeSent()
    {
        if (!$this->paid_at) {
            return false;
        }

        if ($this->sent_at) {
            return false;
        }

        return true;
    }

    /**
     * Has this statement been paid in full?
     * 
     * @return  boolean
     */
    public function hasBeenPaidInFull()
    {
        if (count($this->unsentPayments)) {
            return false;
        }

        return true;
    }

    /**
     * Get the invoices net total for this statement.
     * 
     * @return int
     */
    public function getInvoicesNetTotalAttribute()
    {
        return $this->invoices->sum('net');
    }

    /**
     * Get the invoices tax total for this statement.
     * 
     * @return int
     */
    public function getInvoicesTaxTotalAttribute()
    {
        return $this->invoices->sum('tax');
    }

    /**
     * Get the invoices total for this statement.
     * 
     * @return int
     */
    public function getInvoicesTotalAttribute()
    {
        return $this->invoices_net_total + $this->invoices_tax_total;
    }

    /**
     * Get the expenses total for this statement.
     * 
     * @return int
     */
    public function getExpensesTotalAttribute()
    {
        return $this->expenses->sum('pivot.amount');
    }

    /**
     * Get the net amount for this statement.
     * 
     * @return int
     */
    public function getNetAttribute()
    {
        return $this->invoices_net_total + $this->expenses_total;
    }

    /**
     * Get the tax amount for this statement.
     * 
     * @return int
     */
    public function getTaxAttribute()
    {
        return $this->invoices_tax_total;
    }

    /**
     * Get the total cost for this statement.
     * 
     * @return int
     */
    public function getTotalCostAttribute()
    {
        return $this->net + $this->tax;
    }

    /**
     * Get the landlord payment for this statement.
     * 
     * @return int
     */
    public function getLandlordPaymentAttribute()
    {
        return $this->amount - $this->total_cost;
    }

    /**
     * Get the total amount paid out of this statement.
     * 
     * @return int
     */
    public function getTotalPaidAttribute()
    {
        return $this->sentPayments->sum('amount');
    }

    /**
     * Can this statement be sent?
     * 
     * @return bool
     */
    public function canSend()
    {
        if ($this->sent_at) {
            return false;
        }

        if (! $this->paid_at) {
            return false;
        }

        if ($this->deleted_at) {
            return false;
        }

        return true;
    }
}
