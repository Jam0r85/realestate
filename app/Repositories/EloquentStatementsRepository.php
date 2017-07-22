<?php

namespace App\Repositories;

use App\Statement;
use App\Tenancy;
use Carbon\Carbon;

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
     * Create a new repository instance.
     *
     * @param   EloquentPaymentsRepository $payments
     * @return  void
     */
    public function __construct(EloquentInvoicesRepository $invoices, EloquentStatementPaymentsRepository $statement_payments)
    {
        $this->invoices = $invoices;
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
    public function createStatement(array $data, $tenancy)
    {
        // Find the tenancy.
        $tenancy = Tenancy::findOrFail($tenancy);

        // Build the data array.
        $data['tenancy_id'] = $tenancy->id;
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

        // Mark the statement as either being paid or not.
        if ($statement->paid_at) {
            $data['paid_at'] = NULL;
            $message = 'Unpaid';
        } else {
            $data['paid_at'] = Carbon::now();
            $message = 'Paid';
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
            $data['sent_at'] = NULL;
            $message = 'Unsent';
        } else {
            $data['sent_at'] = Carbon::now();
            $message = 'Sent';
        }

        // Update the statement.
        $this->update($data, $id);

        $this->successMessage('Statement was marked as ' . $message);

        return $statement;
    }
}
