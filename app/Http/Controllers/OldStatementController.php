<?php

namespace App\Http\Controllers;

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
	 * @var \App\Statement
	 */
	public $statement;

	/**
	 * @var \App\Tenancy
	 */
	public $tenancy;

	/**
	 * Build the controller instance.
	 * 
	 * @param \Illuminate\Http\Request $request
	 */
	public function __construct(Request $request)
	{
		$this->tenancy = Tenancy::withTrashed()
			->findOrFail($request->tenancy_id);
	}

	/**
	 * Store the old statement into storage.
	 * 
	 * @param \Illuminate\Http\Request $request
	 * @return void
	 */
    public function store(OldStatementStoreRequest $request)
    {
        $this->storeStatement($request);
        $this->addInvoiceItems($request);
        $this->addExpenses($request);

        $this->statement = $this->statement->fresh();

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

        $this->tenancy->storeStatement($this->statement);

        if ($request->has('users')) {
        	$this->statement->users()->sync($request->users);
        } else {
        	$this->statement->users()->sync($this->tenancy->property->owners);
        }
    }

    /**
     * Add an invoice and it's items to the statement.
     * 
     * @param \Illuminate\Http\Request $request
     */
    private function addInvoiceItems(Request $request)
    {
    	if (!$this->statement) {
    		return;
    	}

    	if ($request->has('invoice_number')) {

    		$total_items = count($request->item_name);

    		for ($i = 0; $i < $total_items; $i++) {
		  		if ($request->item_amount[$i]) {

	        		if (!$this->statement->invoice) {
	        			$invoice = new Invoice();
	        			$invoice->created_at = $invoice->updated_at = $invoice->sent_at = $this->statement->created_at;
	        			$invoice->property_id = $this->tenancy->property->id;
	        			$invoice->number = $request->invoice_number;
	        			$this->statement->storeInvoice($invoice);
	        		}

	        		$item = new InvoiceItem();
	        		$item->name = $request->item_name[$i];
	        		$item->description = $request->item_description[$i];
	        		$item->amount = $request->item_amount[$i];
	        		$item->quantity = $request->item_quantity[$i];
	        		$item->tax_rate_id = $request->item_tax_rate_id[$i];

	        		$invoice->storeItem($item);
	        	}
    		}

    		if ($invoice) {
	            $payment = new StatementPayment();
	            $payment->statement_id = $this->statement->id;
	            $payment->amount = $invoice->total;
	            $payment->sent_at = $this->statement->created_at;
	            $payment->bank_account_id = get_setting('company_bank_account_id', null);

	            $invoice->storeStatementPayment($payment);
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