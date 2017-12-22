<?php

namespace App;

use App\Events\ExpenseStatementPaymentWasSaved;
use App\Events\InvoiceStatementPaymentWasSaved;
use App\Statement;
use Laracasts\Presenter\PresentableTrait;
use Laravel\Scout\Searchable;

class StatementPayment extends BaseModel
{
    use PresentableTrait;

    /**
     * The presented for this model.
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\StatementPaymentPresenter';
    
    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
    protected $dates = ['sent_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'statement_id',
		'amount',
		'bank_account_id',
		'sent_at',
        'parent_type',
        'parent_id'
	];

    /**
     * Get the model created message.
     * 
     * @return  string
     */
    public function messageCreated()
    {
        return $this->present()->name . 's created';
    }

	/**
	 * A statement payment belongs to a statement.
	 */
    public function statement()
    {
    	return $this->belongsTo('App\Statement')->withTrashed();
    }

    /**
     * A statement payment can have a bank account to send the payment to.
     */
    public function bank_account()
    {
        return $this->belongsTo('App\BankAccount')->withTrashed();
    }

    /**
     * A statement payment can have a parent.
     */
    public function parent()
    {
        return $this->morphTo();
    }

    /**
     * A statement payment can have many users.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * A statement payment was created by an owner.
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get the group name for this payment.
     * 
     * @return string
     */
    public function getGroupAttribute()
    {
        if (!$this->parent_type) {
            $this->parent_type = 'landlords';
        }

        return $this->parent_type;
    }

    /**
     * Create and store the statement payments for the given statement.
     * 
     * @param  \App\Statement  $statement
     * @return \App\Statement
     */
    public function createPayments(Statement $statement)
    {
        $this->createInvoicePayment($statement);
        $this->createExpensePayment($statement);
        $this->createLandlordPayment($statement);

        return $statement;
    }

    /**
     * Create and store the invoice statement payments for the given statement.
     * 
     * @param  \App\Statement  $statement
     * @return \App\Statement
     */
    public function createInvoicePayment(Statement $statement)
    {
        $delete = true;

        // Does the statement have invoices?
        if (count($statement->invoices)) {

            // Loop through all of the invoices attached to the statement
            foreach ($statement->invoices as $invoice) {

                // Make sure the invoice has items
                if (count($invoice->items)) {

                    $delete = false;

                    // Update or create the payment
                    $payment = StatementPayment::updateOrCreate(
                        [
                            'statement_id' => $statement->id,
                            'parent_type' => plural_from_model($invoice),
                            'parent_id' => $invoice->id
                        ],
                        [
                            'amount' => $statement->present()->invoicesTotal,
                            'sent_at' => $statement->sent_at,
                            'bank_account_id' => get_setting('company_bank_account_id')
                        ]
                    );

                    // Invoice payments are paid to the company and so should be linked
                    // to the company user as set in the application settings
                    if ($users = get_setting('company_user_id')) {
                        $payment->users()->sync($users);
                    }

                    event (new InvoiceStatementPaymentWasSaved($payment));
                }
            }
        }
        
        if ($delete) {
            StatementPayment::where('statement_id', $statement->id)
                ->where('parent_type', 'invoices')
                ->delete();
        }

        return $statement;
    }

    /**
     * Create the expense statement payments for the given statement.
     * 
     * @param  \App\Statement  $statement
     * @return \App\Statement
     */
    public function createExpensePayment(Statement $statement)
    {
        // Check for attached statement expenses
        if (count($statement->expenses)) {

            // Loop through each expense
            foreach ($statement->expenses as $expense) {

                // Update or create the expense payment
                $payment = StatementPayment::updateOrCreate(
                    [
                        'statement_id' => $statement->id,
                        'parent_type' => plural_from_model($expense),
                        'parent_id' => $expense->id
                    ],
                    [
                        'amount' => $expense->pivot->amount,
                        'sent_at' => $statement->sent_at,
                        'bank_account_id' => $expense->contractor ? $expense->contractor->getSetting('contractor_bank_account_id') : null
                    ]
                );

                // Attach the contractor to the payment
                if ($expense->contractor) {
                    $payment->users()->sync($expense->contractor);
                }

                event (new ExpenseStatementPaymentWasSaved($payment));
            }
        }

        if (!count($statement->expenses)) {
            StatementPayment::where('statement_id', $statement->id)
                ->where('parent_type', 'expenses')
                ->delete();
        }

        return $statement;
    }

    /**
     * Create the landlord statement payment for the given statement.
     * 
     * @param  \App\Statement  $statement
     * @return \App\Statement
     */
    public function createLandlordPayment(Statement $statement)
    {
        // Update or create the payment
        $payment = StatementPayment::updateOrCreate(
            [
                'statement_id' => $statement->id,
                'parent_type' => null
            ],
            [
                'amount' => $statement->present()->landlordBalanceTotal,
                'sent_at' => $statement->sent_at,
                'bank_account_id' => $statement->tenancy->property->bank_account_id ?? null
            ]
        );

        // Attach the statement users to this payment
        $payment->users()->sync($statement->users);

        return $statement;
    }
}
