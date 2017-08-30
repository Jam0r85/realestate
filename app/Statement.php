<?php

namespace App;

use App\Events\StatementCreating;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Statement extends BaseModel
{
    use Searchable;
    use SoftDeletes;

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        $array = $this->only('amount');

        // Get the dates.
        $array['dates'] = [
            'created_at' => $this->created_at,
            'sent_at' => $this->sent_at,
            'paid_at' => $this->paid_at
        ];

        // Get the property name.
        $array['property'] = $this->property->name;

        // Get the tenancy.
        $array['tenancy'] = $this->tenancy->name;

        // Get the amounts.
        $array['amounts'] = [
            'statement' => $this->amount,
            'invoices' => count($this->invoices) ? $this->invoices->sum('total') : null,
            'expenses' => count($this->expenses) ? $this->expenses->sum('pivot.amount') : null,
            'landlord' => $this->landlord_balance_amount
        ];

        // Get the users.
        $array['users'] = count($this->users) ? $this->users->pluck('name')->toArray() : null;

        return $array;
    }
    
    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
    protected $dates = ['period_start','period_end','paid_at','sent_at'];

    /**
     * The attrbites that should be included in the collection.
     * 
     * @var array
     */
    protected $appends = [
        'landlord_balance_amount'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'tenancy_id',
		'key',
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
		return $this->belongsTo('App\Tenancy')
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
        return $this->belongsToMany('App\Expense')
            ->withPivot('amount');
    }

    /**
     * Get the statement name.
     * 
     * @return [type] [description]
     */
    public function getNameAttribute()
    {
    	return date_formatted($this->period_start) . ' - ' . date_formatted($this->period_end);
    }

    /**
     * Get the statement's property.
     * 
     * @return \App\Property
     */
    public function getPropertyAttribute()
    {
    	return $this->property();
    }

    /**
     * Get the statement's invoice.
     * 
     * @return \App\Invoice
     */
    public function getInvoiceAttribute()
    {
        return $this->invoices->first();
    }

    /**
     * Get the statement's invoice total.
     * 
     * @return int
     */
    public function getInvoiceTotalAmountAttribute()
    {
        return $this->invoice ? $this->invoice->total : 0;
    }

    /**
     * Get the statement's expense total
     * 
     * @return int
     */
    public function getExpenseTotalAmountAttribute()
    {
        return $this->expenses->sum('pivot.amount');
    }

    /**
     * Get the statement's balance amount to the landlord.
     * 
     * @return int
     */
    public function getLandlordBalanceAmountAttribute()
    {
        return $this->amount - ($this->invoice_total_amount + $this->expense_total_amount);
    }

    /**
     * Get the statement's net amount.
     * 
     * @return int
     */
    public function getNetAmountAttribute()
    {
        return $this->expense_total_amount + $this->invoices->sum('total_net');
    }

    /**
     * Get the statement's net amount.
     * 
     * @return int
     */
    public function getTaxAmountAttribute()
    {
        return $this->invoices->sum('total_tax');
    }

    /**
     * Get the statement's net amount.
     * 
     * @return int
     */
    public function getTotalAmountAttribute()
    {
        return $this->net_amount + $this->tax_amount;
    }

    /**
     * Get the user email's for this statement.
     * 
     * @return array
     */
    public function getUserEmails()
    {
        if (count($this->users)) {
            return $this->users()->whereNotNull('email')->pluck('email')->toArray();
        }

        return [];
    }

    /**
     * Check whether the statement has valid user email's.
     * 
     * @return bool
     */
    public function hasUserEmails()
    {
        if (!count($this->getUserEmails())) {
            return false;
        }

        return true;
    }

    /**
     * Get the statement's recipient address.
     * 
     * @return string
     */
    public function getRecipientAttribute()
    {
        if (count($this->users)) {
            return $this->users()->first()->home_formatted;
        }

        return '';
    }

    /**
     * Get the statement's recipient address as an inline string.
     * 
     * @return string
     */
    public function getRecipientInlineAttribute()
    {
        return str_replace('<br />', ', ', $this->recipient);
    }

    /**
     * Get the statement's bank account.
     */
    public function getBankAccountAttribute()
    {
        return $this->property->bank_account;
    }

    /**
     * Get the statement's period formatted.
     * 
     * @return string
     */
    public function getPeriodFormattedAttribute()
    {
        return date_formatted($this->period_start) . ' - ' . date_formatted($this->period_end);
    }

    /**
     * Check whether a statement has an invoice.
     * 
     * @return bool
     */
    public function hasInvoice()
    {
        if (count($this->invoices)) {
            return true;
        }

        return false;
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
     * Check whether the statement can be deleted.
     * 
     * @return bool
     */
    public function canDelete()
    {
        if ($this->trashed()) {
            return false;
        }
        
        return true;
    }

    /**
     * Are we sending this statement by post?
     * 
     * @return bool
     */
    public function sendByPost()
    {
        return (boolean) $this->property->hasSetting('post_rental_statement');
    }

    /**
     * Are we sending this statement by email?
     * 
     * @return bool
     */
    public function sendByEmail()
    {
        if ($this->sendByPost()) {
            return false;
        }

        return true;
    }

    /**
     * Mark the statement as being sent by updating the sent_at field.
     *
     * @return  void
     */
    public function setSent($date = null)
    {
        if (is_null($date)) {
            $date = Carbon::now();
        }

        $this->update(['sent_at' => $date]);
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
}
