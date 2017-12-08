<?php

namespace App;

use App\Expense;
use App\Invoice;
use App\Jobs\SendStatementToOwners;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Notification;
use Laracasts\Presenter\PresentableTrait;
use Laravel\Scout\Searchable;

class Statement extends PdfModel
{
    use Searchable;
    use SoftDeletes;
    use PresentableTrait;

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
     * Scope a query to only include sent statements.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent
     */
    public function scopeSent($query)
    {
        return $query
            ->whereNotNull('sent_at')
            ->latest('sent_at')
            ->with('tenancy','tenancy.property','tenancy.tenants','payments','users');
    }

    /**
     * Scope a query to only include sent statements.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent
     */
    public function scopeUnsent($query)
    {
        return $query
            ->where('sent_at', null)
            ->orWhere('paid_at', null)
            ->latest()
            ->with('tenancy','tenancy.property','tenancy.tenants','payments','users');
    }

	/**
	 * A statement can belong to a tenancy.
	 */
	public function tenancy()
	{
		return $this->belongsTo('App\Tenancy')->withTrashed();
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
    	return $this->belongsToMany('App\User');
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
     * Get the invoice total for this statement.
     * 
     * @return int
     */
    public function getInvoiceTotal()
    {
        return $this->invoices->sum('total');
    }

    /**
     * Get the expense total for this statement.
     * 
     * @return int
     */
    public function getExpensesTotal()
    {
        return $this->expenses->sum('pivot.amount');
    }

    /**
     * Get the net amount for ths statement.
     * 
     * @return int
     */
    public function getNetAmount()
    {
        return $this->getExpensesTotal() + $this->invoices->sum('total_net');
    }

    /**
     * Get the tax amount for this statement.
     * 
     * @return int
     */
    public function getTaxAmount()
    {
        return $this->invoices->sum('total_tax');
    }

    /**
     * Get the landlord total for this statement.
     * 
     * @return int
     */
    public function getLandlordAmount()
    {
        return $this->amount - ($this->getInvoiceTotal() + $this->getExpensesTotal());
    }

    /**
     * Get the total amount for this statement.
     * 
     * @return int
     */
    public function getTotal()
    {
        return $this->getNetAmount() + $this->getTaxAmount();
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

        $invoice = $this->invoices()->save($invoice);
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
}
