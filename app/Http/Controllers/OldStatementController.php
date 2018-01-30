<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Http\Requests\OldStatementStoreRequest;
use App\Invoice;
use App\InvoiceItem;
use App\Statement;
use App\StatementPayment;
use App\Tenancy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OldStatementController extends BaseController
{
    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    public $model = 'App\Statement';

    /**
     * The tenancy we are dealing with.
     * 
     * @var \App\Tenancy
     */
    public $tenancy;

    /**
     * The old statement.
     * 
     * @var \App\Statement
     */
    public $statement;

    /**
     * The invoice we maybe dealing with.
     * 
     * @var \App\Invoice
     */
    public $invoice;

    /**
     * Show the form for creating a new resource.
     * 
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $tenancy = Tenancy::withTrashed()
            ->findOrFail($id);

        return view('old-statements.create', compact('tenancy'));
    }

	/**
	 * Store the old statement into storage.
	 * 
	 * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
	 * @return void
	 */
    public function store(OldStatementStoreRequest $request, $id)
    {
        // Find the tenancy
        $this->tenancy = Tenancy::withTrashed()
            ->findOrFail($id);

        $this->statement = $this->repository->fill([
            'created_at' => $request->created_at,
            'period_start' => $request->period_start,
            'period_end' => $request->period_end,
            'amount' => $request->amount,
            'sent_at' => $request->created_at,
            'paid_at' => $request->created_at
        ]);

        // Store the statement to the tenancy
        $this->tenancy->storeOldstatement($this->statement);

        // Update the tenancy rent balance
        $this->tenancy = $this->tenancy->fresh();
        $this->tenancy->updateRentBalance();

        // Create and attach the invoice items.
        $this->addInvoiceItems($request);

        // Create and attach the expenses.
        $this->addExpenses($request);

        // Get the fresh statement
        $this->statement = $this->statement->fresh();

        // Create the payments.
        $payments = new StatementPayment();
        $payments->createPayments($this->statement);

        return back();
    }

    /**
     * Add an invoice and it's items to the statement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Statement
     */
    private function addInvoiceItems(Request $request)
    {
        // Make sure the request has a valid invoice number
    	if ($request->has('invoice_number') && $request->invoice_number) {

    		$total_items = count($request->item_name);

            // Make sure we have invoice items to add
            if ($total_items > 0) {
        		for ($i = 0; $i < $total_items; $i++) {

    		  		if ($request->item_amount[$i]) {

                        // Does the statement have an invoice?
                        if (! $this->invoice) {

                            $this->invoice = new Invoice();
                            $this->invoice->fill([
                                'created_at' => $this->statement->created_at,
                                'updated_at' => $this->statement->created_at,
                                'sent_at' => $this->statement->created_at,
                                'property_id' => $this->tenancy->property_id,
                                'number' => $request->invoice_number
                            ]);

                            // Save the invoice to the statement
                            $this->statement->invoices()->save($this->invoice);

                            // Attach the users to the invoice
                            $this->invoice->users()->sync($request->users);
                        }

    	        		$item = new InvoiceItem();
    	        		$item->name = $request->item_name[$i];
    	        		$item->description = $request->item_description[$i];
    	        		$item->amount = $request->item_amount[$i];
    	        		$item->quantity = $request->item_quantity[$i];
    	        		$item->tax_rate_id = $request->item_tax_rate_id[$i];

    	        		$this->invoice->storeItem($item);
    	        	}
        		}
            }
    	}
    }

    /**
     * Add the expenses to the old statement.
     *
     * @param \Illuminate\Http\Request $request
     */
    private function addExpenses(Request $request)
    {
    	$total_expenses = count($request->expense_name);

    	for ($i = 0; $i < $total_expenses; $i++) {
    		if ($request->expense_cost[$i]) {

                // Build the expense.
    			$expense = new Expense();

    			$expense->contractor_id = $request->expense_contractor_id[$i];
    			$expense->name = $request->expense_name[$i];
    			$expense->cost = $request->expense_cost[$i];
    			$expense->created_at = $this->statement->created_at;
                $expense->paid_at = $this->statement->created_at;

                // Store the expense to the property.
    			$this->tenancy->property->storeExpense($expense);

                // Attach the expense to the statement
    			$this->statement->attachExpense($expense);
    		}
    	}
    }
}