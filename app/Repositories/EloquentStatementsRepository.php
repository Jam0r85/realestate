<?php

namespace App\Repositories;

use App\Mail\StatementToLandlord;
use App\Statement;
use App\Tenancy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class EloquentStatementsRepository extends EloquentBaseRepository
{
    /**
     * @var  App\Repositories\EloquentInvoicesRepository
     */
    public $invoices;

    /**
     * @var  App\Repositories\EloquentStatementPaymentsRepository
     */
    public $statement_payments;

    /**
     * @var  App\Repositories\EloquentExpensesRepository
     */
    public $expenses;

    /**
     * @var  App\Repositories\EloquentPropertiesRepository
     */
    public $properties;

    /**
     * Create a new repository instance.
     *
     * @param   EloquentPaymentsRepository $payments
     * @return  void
     */
    public function __construct(EloquentPropertiesRepository $properties, EloquentInvoicesRepository $invoices, EloquentExpensesRepository $expenses, EloquentStatementPaymentsRepository $statement_payments)
    {
        $this->properties = $properties;
        $this->invoices = $invoices;
        $this->expenses = $expenses;
        $this->statement_payments = $statement_payments;
    }

    /**
     * Get the class name.
     *
     * @return string
     */
    public function getClassPath()
    {
        return 'App\Statement';
    }

    /**
     * Get all records in the repo and paginate them.
     *
     * @return mixed
     */
    public function getSentPaged()
    {
        return $this->getInstance()->whereNotNull('sent_at')->with('tenancy', 'tenancy.property', 'users')->latest()->paginate();
    }

    /**
     * Get all records in the repo and paginate them.
     *
     * @return mixed
     */
    public function getUnsentPaged()
    {
        return $this->getInstance()->whereNull('sent_at')->orWhereNull('paid_at')->with('tenancy', 'tenancy.property', 'users')->latest()->paginate();
    }

    /**
     * Create a new statement for a tenancy.
     *
     * @param  array  $data
     * @param  [type] $tenancy [description]
     * @return [type]          [description]
     */
    public function createStatement(array $data, $id)
    {
        // Find the tenancy.
        if (isset($data['tenancy_id'])) {
            $tenancy = Tenancy::findOrFail($data['tenancy_id']);
        } else {
            $tenancy = Tenancy::findOrFail($id);
            $data['tenancy_id'] = $tenancy->id;
        }

        // Build the data array.
        $data['key'] = str_random(30);

        // Set the statement amount.
        if (!isset($data['amount'])) {
            $data['amount'] = $tenancy->rent_amount;
        }

        // Set the statement start period.
        if (!isset($data['period_start'])) {
            $data['period_start'] = $tenancy->next_statement_start_date;
        }

        // Set the statement end period.
        if (!isset($data['period_end'])) {
            $data['period_end'] = Carbon::createFromFormat('Y-m-d', $data['period_start'])->addMonth()->subDay();
        }

        // Create the statement
        $statement = $this->create($data);

        // Attach the property owners to the statement.
        $statement->users()->sync($tenancy->property->owners);

        // Create the service charge invoice should we need to.
        if ($tenancy->service_charge_amount) {

            // Create an invoice.
            $invoice = $this->invoices->createInvoice([
                'property_id' => $tenancy->property_id
            ]);

            // Attach the property owners to the invoice.
            $invoice->users()->sync($tenancy->property->owners);

            // Create the service charge invoice item.
            $item = $this->invoices->createInvoiceItem([
                'name' => $tenancy->service->name,
                'description' => $tenancy->service->description,
                'quantity' => 1,
                'amount' => $tenancy->service_charge_amount,
                'tax_rate_id' => $tenancy->service->tax_rate_id
            ], $invoice);

            // Attach the invoice to the statement.
            $statement->invoices()->attach($invoice);
        }

        return $statement;
    }

    /**
     * Update the statement.
     * 
     * @param  array        $data
     * @param  statement    $id 
     * @return mixed
     */
    public function updateStatement(array $data, $id)
    {
        $statement = $this->find($id);

        if (isset($data['period_start'])) {
            $data['period_start'] = Carbon::createFromFormat('Y-m-d', $data['period_start']);
        }

        if (isset($data['period_end'])) {
            $data['period_end'] = Carbon::createFromFormat('Y-m-d', $data['period_end']);
        }

        $this->update($data, $statement);

        if (isset($data['sending_method'])) {
            $this->properties->updateStatementSendingMethod($data['sending_method'], $statement->property->id);
        }

        if (isset($data['bank_account_id'])) {
            $this->properties->updateBankAccount($data['bank_account_id'], $statement->property->id);
        }

        return $statement;
    }

    /**
     * Store a new invoice item for a rental statement.
     *
     * @param  array           $data
     * @param  \App\Statement. $id
     * @return mixed
     */
    public function createInvoiceItem(array $data, $id)
    {
        $statement = $this->find($id);

        // Statement doesn't have a current invoice attached to it.
        if (!$statement->hasInvoice()) {

            // Create an invoice.
            $invoice = $this->invoices->createInvoice([
                'property_id' => $statement->property->id
            ]);

            // Attach the invoice to the rental statement.
            $statement->invoices()->attach($invoice);

            // Sync the users from the statement to the invoice.
            $invoice->users()->sync($statement->users);
        } else {
            $invoice = $statement->invoice;
        }

        // Create the invoice item.
        $item = $this->invoices->createInvoiceItem($data, $invoice);

        $this->successMessage('The invoice item was created');

        return $item;
    }

    /**
     * Store a new expense item for a rental statement.
     *
     * @param  array           $data
     * @param  \App\Statement. $id
     * @return mixed
     */
    public function createExpenseItem(array $data, $id)
    {
        // Find the statement.
        $statement = $this->find($id);

        // Insert the property_id into the data array.
        $data['property_id'] = $statement->property->id;

        // Create the expense.
        $expense = $this->expenses->createExpense($data);

        // Attach the expense to the statement.
        $statement->expenses()->attach($expense, ['amount' => $data['cost']]);

        // Flash a success message.
        $this->successMessage('The expense item was created');

        return $expense;
    }

    /**
     * Create the statement payments.
     *
     * @param  \App\Statement $id
     * @return mixed
     */
    public function createPayments($id)
    {
        // Find the statement.
        $statement = $this->find($id);

        // Generate the payments
        $this->statement_payments->createPayments($statement);

        // Flash a success message.
        $this->successMessage('Statement payments were created');

        return $statement;
    }

    /**
     * Toggle a statement as being paid or unpaid.
     *
     * @param  \App\Statement $id
     * @return \App\Statement
     */
    public function togglePaid($id)
    {
        // Find the statement.
        $statement = $this->find($id);

        if ($statement->paid_at) {
            // Mark the statement as being Unpaid.
            $data['paid_at'] = null;
            $message = 'Unpaid';

            // Update the invoice as being unpaid.
            if ($statement->invoice) {
                $statement->invoice->update(['paid_at' => null]);
            }
        } else {
            // Mark the statement as being Paid.
            $data['paid_at'] = Carbon::now();
            $message = 'Paid';

            // Generate the statement payments should none have been created before hand.
            if (!count($statement->payments)) {
                $this->statement_payments->createPayments($statement);
            }

            // Update the invoice as being paid.
            if ($statement->invoice) {
                $statement->invoice->update(['paid_at' => Carbon::now()]);
            }

            // Mark the statement payments as being sent.
            $statement->payments()->whereNull('sent_at')->update(['sent_at' => Carbon::now()]);
        }

        // Update the statement.
        $this->update($data, $id);

        $this->successMessage('Statement was marked as ' . $message);

        return $statement;
    }

    /**
     * Toggle a statement as being paid or unpaid.
     *
     * @param  \App\Statement $id
     * @return \App\Statement
     */
    public function toggleSent($id)
    {
        // Find the statement.
        $statement = $this->find($id);

        // Mark the statement as either being sent or not.
        if ($statement->sent_at) {
            $data['sent_at'] = null;
            $message = 'Unsent';
        } else {
            $data['sent_at'] = Carbon::now();
            $message = 'Sent';

            // Update the invoice as being paid.
            if ($statement->invoice) {
                $statement->invoice->update(['sent_at' => Carbon::now()]);
            }
        }

        // Update the statement.
        $this->update($data, $id);

        $this->successMessage('Statement was marked as ' . $message);

        return $statement;
    }

    /**
     * Send the statements.
     *
     * @param  [type] $ids [description]
     * @return [type]      [description]
     */
    public function send($ids)
    {
        if (!is_array($ids)) {
            $ids = explode(',', $ids);
        }

        // Loop through the provided statement IDs
        foreach ($ids as $id) {
            
            // Find the statement
            $statement = $this->find($id);

            // Make sure there is at least one statement user with an email.
            $emails = [];
            
            foreach ($statement->users as $user) {
                if ($user->email) {
                    $emails[] = $user->email;
                }
            }

            // Send the email.
            if (count($emails)) {
                Mail::to($emails)->send(new StatementToLandlord($statement));
            } else {
                flash('Statement email not sent')->info();
            }

            // Update the statement sent date.
            $statement->update(['sent_at' => Carbon::now()]);
        }

        $this->successMessage('Statements were sent');
        return true;
    }
}
