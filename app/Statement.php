<?php

namespace App;

use App\Expense;
use App\Invoice;
use App\InvoiceItem;
use App\Jobs\SendStatementToOwners;
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
		'sent_at'
	];

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
        return $this->belongsTo('App\User');
    }

    /**
     * A statement can belong to many invoices.
     */
    public function invoices()
    {
        return $this->belongsToMany('App\Invoice');
    }

    /**
     * A statement can have many payments out to landlords, contractors, etc.
     */
    public function payments()
    {
        return $this->hasMany('App\StatementPayment');
    }

    /**
     * A statement can have many expenses.
     */
    public function expenses()
    {
        return $this->belongsToMany('App\Expense')->withPivot('amount');
    }

    /**
     * Get the statement's bank account.
     */
    public function getBankAccountAttribute()
    {
        return $this->property()->bank_account;
    }

    /**
     * Check whether a statement has unsent payments.
     * 
     * @return int
     */
    public function hasUnsentPayments()
    {
        return $this->payments()->whereNull('sent_at')->count();
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
     * @param  \App\Invoice  $invoice  the invoice we are storing
     * @return  \App'Invoice
     */
    public function storeInvoice(Invoice $invoice = null)
    {
        if (is_null($invoice)) {
            $invoice = new Invoice();
        }
        
        $invoice->property_id = $this->tenancy->property_id;

        $this->invoices()->save($invoice);
        $invoice->users()->sync($this->property()->owners);

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
        SendStatementToOwners::dispatch($this);
        
        $this->sent_at = Carbon::now();
        $this->saveWithMessage('has been sent');
    }

    /**
     * Create the invoice items for this statement.
     * 
     * @return void
     */
    public function createInvoiceItems()
    {
        $this->createInvoiceManagementItem();
        $this->createInvoiceLettingItem();
        $this->createInvoiceReLettingItem();

        return $this;
    }

    /**
     * Create the invoice management item.
     * 
     * @return void
     */
    public function createInvoiceManagementItem()
    {
        $tenancy = $this->tenancy;
        $service = $tenancy->service;
        $property = $tenancy->property;

        // Is this the first tenancy for this property?
        if (!count($property->tenancies)) {

            // Is this the first statement for this tenancy?
            if (count($tenancy->statements) <= 1) {

                // Set the re-letting fee from the service
                $lettingFee = $service->re_letting_fee;

                // Loop through the property owners and see whether there is a custom letting fee instead
                foreach ($property->owners as $user) {
                    if ($fee = $user->getSetting('tenancy_service_letting_fee')) {
                        $lettingFee = $fee;
                    }
                }

                // Is the letting fee a valid amount?
                if ($lettingFee > 0) {

                    if (!count($this->invoices)) {
                        $invoice = $this->storeInvoice();
                    } else {
                        $invoice = $this->invoices->first();
                    }

                    $item = new InvoiceItem();
                    $item->name = $service->name;
                    $item->description = $service->name . ' Letting Fee';
                    $item->amount = $lettingFee;
                    $item->quantity = 1;
                    $item->tax_rate_id = $service->tax_rate_id;

                    $invoice->storeItem($item);
                }
            }
        }

        return $this;
    }

    /**
     * Create the invoice letting item.
     * 
     * @return void
     */
    public function createInvoiceLettingItem()
    {
        $tenancy = $this->tenancy;
        $service = $tenancy->service;
        $property = $tenancy->property;

        // Is this the first tenancy for this property?
        if (count($property->tenancies) >= 1) {

            // Is this the first statement for this tenancy?
            if (count($tenancy->statements) <= 1) {

                // Set the re-letting fee from the service
                $reLettingFee = $service->re_letting_fee;

                // Loop through the property owners and see whether there is a custom letting fee instead
                foreach ($property->owners as $user) {
                    if ($fee = $user->getSetting('tenancy_service_re_letting_fee')) {
                        $reLettingFee = $fee;
                    }
                }

                // Is the letting fee a valid amount?
                if ($reLettingFee > 0) {

                    // Grab the statement invoice or create one if not present.
                    if (!count($this->invoices)) {
                        $invoice = $this->storeInvoice();
                    } else {
                        $invoice = $this->invoices->first();
                    }

                    $item = new InvoiceItem();
                    $item->name = $service->name;
                    $item->description = $service->name . ' Re-Letting Fee';
                    $item->amount = $reLettingFee;
                    $item->quantity = 1;
                    $item->tax_rate_id = $service->tax_rate_id;

                    $invoice->storeItem($item);
                }
            }
        }

        return $this;
    }

    /**
     * Create the invoice re-letting item.
     * 
     * @return void
     */
    public function createInvoiceReLettingItem()
    {
        $tenancy = $this->tenancy;
        $service = $tenancy->service;

        // Do we have a valid service charge amount?
        if ($tenancy->getServiceChargeNetAmount() > 0) {

            if (!count($this->invoices)) {
                $invoice = $this->storeInvoice();
            } else {
                $invoice = $this->invoices->first();
            }

            // Format the description
            $description = $service->name . ' service at ' . $service->charge_formatted;

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
            $item->amount = $tenancy->getServiceChargeNetAmount($this->amount);
            $item->quantity = 1;
            $item->tax_rate_id = $service->tax_rate_id;

            $invoice->storeItem($item);
        }

        return $this;
    }
}
