<?php

namespace App;

use App\Document;
use App\Property;
use App\Statement;
use App\StatementPayment;
use App\Traits\DataTrait;
use App\Traits\DocumentsTrait;
use App\User;
use Carbon\Carbon;
use EloquentFilter\Filterable;
use Illuminate\Support\Facades\Storage;
use Laracasts\Presenter\PresentableTrait;
use Laravel\Scout\Searchable;

class Expense extends BaseModel
{
    use Searchable,
        DocumentsTrait,
        PresentableTrait,
        Filterable,
        DataTrait;

    /**
     * The presenter for this model.
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\ExpensePresenter';

    /**
     * The document name type.
     * 
     * @var string
     */
    protected $documentNameType = 'invoice';

    /**
     * The base path to the document storage for this model.
     * 
     * @var string
     */
    protected $documentPath = 'expenses';

    /**
     * The attributes that should be eager loaded.
     * 
     * @var array
     */
    public $with = [
        'contractor'
    ];

    /**
     * Boot the eloquent model.
     * 
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (! $model->balance) {
                $model->balance = $model->cost;
            }

        });
        
        static::deleted(function ($model) {

            // Delete all documents associated with this model
            foreach ($model->documents as $document) {
                Storage::delete($document->path);
                $document->forceDelete();
            }
            
        });
    }

    /**
     * Set the cost of the expense to pence.
     * 
     * @param  integer  $value
     * @return void
     */
    public function setCostAttribute($value)
    {
        $this->attributes['cost'] = pounds_to_pence($value);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        $array = $this->only('name','cost','created_at','paid_at');
        $array['invoice'] = $this->getData('contractor_reference');
        $array['property'] = $this->property->present()->fullAddress;
        $array['contractor'] = $this->contractor ? $this->contractor->name : null;

        return $array;
    }

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
    protected $dates = [
        'paid_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'cost',
        'balance',
        'paid_at',
        'contractor_id',
        'property_id',
        'data'
    ];

    /**
     * The allowed keys in the data column.
     * 
     * @var  array
     */
    public $dataKeys = [
        'contractor_reference',
        'disable_paid_notification',
        'already_paid'
    ];

    /**
     * An expense can have a contractor.
     */
    public function contractor()
    {
        return $this
            ->belongsTo(User::class, 'contractor_id');
    }

    /**
     * An expense has one owner.
     */
    public function owner()
    {
        return $this
            ->belongsTo(User::class, 'user_id');
    }

    /**
     * An expense belongs to one property.
     */
    public function property()
    {
        return $this
            ->belongsTo(Property::class);
    }

    /**
     * An expense can belong to many statements with an amount.
     */
    public function statements()
    {
        return $this
            ->belongsToMany(Statement::class)
            ->withPivot('amount');
    }

    /**
     * An expense can have many statement payments.
     */
    public function payments()
    {
        return $this
            ->morphMany(StatementPayment::class, 'parent');
    }

    /**
     * An expense can have many sent statement payments.
     */
    public function paymentsSent()
    {
        return $this
            ->morphMany(StatementPayment::class, 'parent')
            ->whereNotNull('sent_at');
    }

    /**
     * Store a payment against this expense.
     * 
     * @param \App\StatementPayment $payment
     * @return void
     */
    public function storePayment(StatementPayment $payment)
    {
        $this->payments()->save($payment);
        $payment->users()->attach($this->contractor);
    }

    /**
     * Update the balances for this expense.
     * 
     * @return void
     */
    public function updateBalances()
    {
        $this->balance = $this->cost - $this->payments->sum('amount');

        if ($this->balance <= 0) {
            if (!$this->paid_at) {
                $this->paid_at = Carbon::now();
            }
        } else {
            $this->paid_at = null;
        }

        return $this->saveWithMessage('balance updated');
    }

    /**
     * Has this expense been paid?
     * 
     * @return boolean
     */
    public function isPaid()
    {
        if ($this->balance > 0) {
            return false;
        }

        return true;
    }

    /**
     * Can we send a paid notification to the contractor?
     * 
     * @return  bool
     */
    public function canSendPaymentSentNotification()
    {       
        // Notification disabled
        if ($this->getData('disable_paid_notification') == 'yes') {
            return false;
        }

        // Expense has already been paid, do not send out the notification
        if ($this->getData('already_paid') == 'yes') {
            return false;
        }

        // No contractor assigned to the expense
        if (!$this->contractor) {
            return false;
        }

        // Contractor does not have expense notification settings set
        if (!$this->contractor->getSetting('expense_paid_notifications')) {
            return false;
        }

        return true;
    }

    /**
     * Can we send a received notification to the contractor?
     * 
     * @return  bool
     */
    public function canSendReceivedNotification()
    {
        // No contractor assigned to the expense
        if (!$this->contractor) {
            return false;
        }

        // Contractor does not want to receive these notifications
        if (!$this->contractor->getSetting('expense_received_notifications')) {
            return false;
        }

        return true;
    }

    /**
     * Get the bank account used by the contractor of this expense to pay them.
     * 
     * @return mixed
     */
    public function getBankAccount()
    {
        // Expense does not have a contractor
        if (!$this->contractor) {
            return null;
        }

        return $this->contractor->getContractorBankAccountId();
    }
}
