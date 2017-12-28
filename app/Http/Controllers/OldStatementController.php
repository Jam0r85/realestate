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
        $tenancy = Tenancy::withTrashed()->findOrFail($id);

        // Build up the statement data
        $data = $request->only('created_at','period_start','period_end','amount');
        $data['sent_at'] = $data['created_at'];
        $data['paid_at'] = $data['created_at'];

        $statement = $this->repository
            ->fill($data);

        $tenancy->storeOldstatement($statement);

        $this->addInvoiceItems($statement, $request);
        $this->addExpenses($statement, $request);

        // Landlord Payment
        $payment = new StatementPayment();
        $payment->statement_id = $this->statement->id;
        $payment->amount = $this->statement->landlord_balance_amount;
        $payment->sent_at = $request->created_at;
        $payment->bank_account_id = $this->statement->property->bank_account_id;
        $payment->save();

        $this->successMessage('The old statement was created');
        return back();
    }

    /**
     * Build the old statement and store it in storage.
     * 
     * @param \Illuinmate\Http\Requests $request
     * @return \App\Statement
     */
    private function storeStatement(Request $request)
    {
        $this->statement = new Statement();
        $this->statement->period_start = $request->period_start ?? $this->tenancy->nextStatementDate();
        $this->statement->period_end = $request->period_end;
        $this->statement->amount = $request->amount;
        $this->statement->created_at = $this->statement->updated_at = $this->statement->paid_at = $this->statement->sent_at = Carbon::createFromFormat('Y-m-d', $request->created_at);

    }

    /**
     * Add an invoice and it's items to the statement.
     *
     * @param  \App\Statement  $statement
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Statement
     */
    private function addInvoiceItems(Statement $statement, Request $request)
    {
        // Make sure the request has a valid invoice number
    	if ($request->has('invoice_number')) {

    		$total_items = count($request->item_name);

            // Make sure we have invoice items to add
            if ($total_items > 0) {
                // Does the statement have an invoice?
                if (!count($statement->invoices)) {
                    $invoice = new Invoice();
                    $invoice->created_at = $invoice->updated_at = $invoice->sent_at = $statement->created_at;
                    $invoice->property_id = $statement->tenancy->property_id;
                    $invoice->number = $request->invoice_number;

                    // Save the invoice to the statement
                    $statement->invoices()->save($invoice);

                    // Attach the users to the invoice
                    $invoice->users()->sync($request->users);
                }
            }

    		for ($i = 0; $i < $total_items; $i++) {
		  		if ($request->item_amount[$i]) {

	        		$item = new InvoiceItem();
	        		$item->name = $request->item_name[$i];
	        		$item->description = $request->item_description[$i];
	        		$item->amount = $request->item_amount[$i];
	        		$item->quantity = $request->item_quantity[$i];
	        		$item->tax_rate_id = $request->item_tax_rate_id[$i];

	        		$invoice->storeItem($item);
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
    	if (!$this->statement) {
    		return;
    	}

        $this->statement->fresh();

    	$total_expenses = count($request->expense_name);

    	for ($i = 0; $i < $total_expenses; $i++) {
    		if ($request->expense_cost[$i]) {

    			$expense = new Expense();
    			$expense->contractor_id = $request->expense_contractor_id[$i];
    			$expense->name = $request->expense_name[$i];
    			$expense->cost = $request->expense_cost[$i];
    			$expense->created_at = $expense->paid_at = $this->statement->created_at;

    			$this->tenancy->property->storeExpense($expense);
    			$this->statement->attachExpense($expense);

	            $payment = new StatementPayment();
	            $payment->statement_id = $this->statement->id;
	            $payment->amount = $expense->cost;
	            $payment->sent_at = $this->statement->created_at;

	            $expense->storePayment($payment);
    		}
    	}
    }
}