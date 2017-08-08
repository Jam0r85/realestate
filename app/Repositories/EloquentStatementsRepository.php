<?php

namespace App\Repositories;

use App\Invoice;
use App\Jobs\SendStatement;
use App\Mail\StatementToLandlord;
use App\Repositories\EloquentPaymentsRepository;
use App\Statement;
use App\Tenancy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class EloquentStatementsRepository extends EloquentBaseRepository
{
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
        return $this->getInstance()
            ->whereNotNull('sent_at')
            ->with('tenancy', 'tenancy.property', 'users')
            ->latest('sent_at')
            ->paginate();
    }

    /**
     * Get all records in the repo and paginate them.
     *
     * @return mixed
     */
    public function getUnsentPaged()
    {
        return $this->getInstance()
            ->whereNull('sent_at')
            ->with('tenancy', 'tenancy.property', 'users')
            ->latest()
            ->paginate();
    }

    /**
     * Get all records in the repo and paginate them.
     *
     * @return mixed
     */
    public function getUnpaidPaged()
    {
        return $this->getInstance()
            ->whereNull('paid_at')
            ->with('tenancy', 'tenancy.property', 'users')
            ->latest()
            ->paginate();
    }

    /**
     * Get all of the unsent statements.
     *
     * @return mixed
     */
    public function getUnsentList()
    {
        return $this->getInstance()
            ->whereNull('sent_at')
            ->latest()
            ->get();
    }

    /**
     * Get all of the unpaid statements.
     *
     * @return mixed
     */
    public function getUnpaidList()
    {
        return $this->getInstance()
            ->whereNull('paid_at')
            ->get();
    }

    /**
     * Create a new statement for a tenancy.
     *
     * @param  array  $data
     * @param  [type] $tenancy [description]
     * @param boolean $service_charge
     * @return [type]          [description]
     */
    public function createStatement(array $data, $id, $service_charge = true)
    {
        if (isset($data['tenancy_id'])) {
            $tenancy = Tenancy::findOrFail($data['tenancy_id']);
        } else {
            $tenancy = Tenancy::findOrFail($id);
            $data['tenancy_id'] = $tenancy->id;
        }

        $data['key'] = str_random(30);

        if (!isset($data['amount'])) {
            $data['amount'] = $tenancy->rent_amount;
        }

        // Set the statement start period.
        if (!isset($data['period_start'])) {
            $data['period_start'] = $tenancy->next_statement_start_date;
        } else {
            $data['period_start'] = Carbon::createFromFormat('Y-m-d', $data['period_start']);
        }

        // Set the statement end period.
        if (!isset($data['period_end'])) {
            $data['period_end'] = clone $data['period_start'];
            $data['period_end']->addMonth()->subDay();
        } else {
            $data['period_end'] = Carbon::createFromFormat('Y-m-d', $data['period_end']);
        }

        // Create the statement
        $statement = $this->create($data);

        // Update the created at date if present.
        if (isset($data['created_at'])) {
            $statement->created_at = Carbon::createFromFormat('Y-m-d', $data['created_at']);
            $statement->save();
        }

        // Attach the property owners to the statement.
        $statement->users()->sync($tenancy->property->owners);

        // Create the service charge invoice should we need to.
        if ($tenancy->service_charge_amount && $service_charge == true) {

            // Create an invoice.
            $invoices_repo = new EloquentInvoicesRepository();
            $invoice = $invoices_repo->createInvoice([
                'created_at' => $statement->created_at,
                'property_id' => $tenancy->property_id
            ]);

            // Attach the property owners to the invoice.
            $invoice->users()->sync($tenancy->property->owners);

            // Create the service charge invoice item.
            $item = $invoices_repo->createInvoiceItem([
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
     * Create an old rental statement.
     * 
     * @param  array  $data [description]
     * @param  [type] $id   [description]
     * @return [type]       [description]
     */
    public function createOldStatement(array $data, $id)
    {
        // Find the tenancy.
        if (isset($data['tenancy_id'])) {
            $tenancy = Tenancy::findOrFail($data['tenancy_id']);
        } else {
            $tenancy = Tenancy::findOrFail($id);
            $data['tenancy_id'] = $tenancy->id;
        }

        // First we record the rent payment for the tenancy.
        $payments_repo = new EloquentPaymentsRepository();
        $payment = $payments_repo->createPayment([
            'amount' => $data['rent_received'] ? $data['rent_received'] : $data['amount'],
            'created_at' => $data['created_at'],
            'payment_method_id' => $data['payment_method_id']
        ], $tenancy, 'rent_payments', 'tenants');

        // Create the statement
        $statement = $this->createStatement($data, $id, false);

        // Make sure we have an invoice number
        if ($data['invoice_number']) {

            $total_items = count(array_where($data['item_name'], function ($value, $key) {
                return !is_null($value);
            }));

            // Add the invoice items should there be any.
            if (count($data['item_name'])) {
                for ($i = 0; $i < $total_items; $i++) {

                    $item['name'] = $data['item_name'][$i];
                    $item['description'] = $data['item_description'][$i];
                    $item['quantity'] = $data['item_quantity'][$i];
                    $item['amount'] = $data['item_amount'][$i];
                    $item['tax_rate_id'] = $data['item_tax_rate_id'][$i];
                    $item['invoice_number'] = $data['invoice_number'];

                    $this->createInvoiceItem($item, $statement);
                }
            }
        }

        $this->togglePaid([$statement->id]);
        $this->toggleSent($statement);

        return $tenancy;
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
        // Set the period_start.
        if (isset($data['period_start'])) {
            $data['period_start'] = Carbon::createFromFormat('Y-m-d', $data['period_start']);
        }

        // Set the period_end.
        if (isset($data['period_end'])) {
            $data['period_end'] = Carbon::createFromFormat('Y-m-d', $data['period_end']);
        }

        // Update the statement.
        $statement = $this->update($data, $id);

        // Update the sending_method for the statement and property.
        if (isset($data['sending_method'])) {
            $properties_repo = new EloquentPropertiesRepository();
            $properties_repo->updateStatementSendingMethod($data['sending_method'], $statement->property->id);
        }

        // Update the bank account for the statement and property.
        if (isset($data['bank_account_id'])) {
            $properties_repo = new EloquentPropertiesRepository();
            $properties_repo->updateBankAccount($data['bank_account_id'], $statement->property->id);
        }

        // Update the created_at date.
        if (isset($data['created_at'])) {
            $statement->created_at = Carbon::createFromFormat('Y-m-d', $data['created_at']);
            $statement->save();
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
        $invoices_repo = new EloquentInvoicesRepository();

        $statement = $this->find($id);

        // Statement doesn't have a current invoice attached to it.
        if (!$statement->hasInvoice()) {

            // Create an invoice.
            $invoice = $invoices_repo->createInvoice([
                'property_id' => $statement->property->id,
                'number' => $data['invoice_number']
            ]);

            // Attach the invoice to the rental statement.
            $statement->invoices()->attach($invoice);

            // Sync the users from the statement to the invoice.
            $invoice->users()->sync($statement->users);
        } else {
            $invoice = $statement->invoice;
        }

        // Create the invoice item.
        $item = $invoices_repo->createInvoiceItem($data, $invoice);

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
        $expenses_repo = new EloquentExpensesRepository();
        $expense = $expenses_repo->createExpense($data);

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

        $statement_payments_repo = new EloquentStatementPaymentsRepository();

        // Generate the payments
        $statement_payments_repo->createPayments($statement);

        // Flash a success message.
        $this->successMessage('Statement payments were created');

        return $statement;
    }

    /**
     * Toggle the provided statements as being paid.
     *
     * @param  array $ids
     * @return \App\Statement
     */
    public function togglePaid(array $ids)
    {
        foreach ($ids as $id) {

            // Find the statement.
            $statement = $this->find($id);

            // Statement is paid.
            if (!is_null($statement->paid_at)) {
                // Mark the statement as being Unpaid.
                $data['paid_at'] = null;
                $message = 'Unpaid';
            } else {
                // Mark the statement as being Paid.
                $data['paid_at'] = Carbon::now();
                $message = 'Paid';
            }

            // Update the statement.
            $statement->update(['paid_at' => $data['paid_at']]);
        }

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

            if ($statement->invoice) {
                $invoices_repo = new EloquentInvoicesRepository();
                $invoice = $invoices_repo->find($statement->invoice);
                $invoice->sent_at = Carbon::now();
            }
        }

        $this->update($data, $id);

        $this->successMessage('Statement was marked as ' . $message);

        return $statement;
    }

    /**
     * Loop through the given statement ids and send each one
     *
     * @param array $ids
     * @return \App\Statement
     */
    public function send($ids, $checks = false)
    {
        foreach($ids as $id) {
            $statement = $this->find($id);

            if ($checks == true) {
                
                // Statement has already been sent, we return.
                if ($statement->sent_at) {
                    return;
                }

                // Statement has not been paid in full, we return.
                if (!$statement->paid_at) {
                    return;
                }
            }

            $job = (new SendStatement($statement));

            dispatch($job);

            // We mark the statement as have being sent to prevent duplicate requests to send.
            $statement->update(['sent_at' => Carbon::now()]);
        }

        $this->successMessage('The statements were added to send queue');

        return $statement;
    }

    /**
     * Send the given statements.
     * 
     * @param  array  $ids
     * @return void
     */
    public function sendStatements($ids = [])
    {
        $this->send($ids);
    }

    /**
     * Send the given statements but perform some security checks before hand to precent
     * duplicate statements being sent to owners.
     * 
     * @param  array  $ids
     * @return void
     */
    public function sendStatementsWithChecks($ids = [])
    {
        $this->send($ids, true);
    }

    /**
     * Archive the statement.
     *
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function archiveStatement($id)
    {
        $statement = $this->archive($id);

        if ($statement->invoice) {
            $this->invoices->archiveInvoice($statement->invoice->id);
        }

        $statement->tenancy->setOverdueStatus();

        return $statement;
    }
}
