<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceItem;
use App\Statement;
use App\StatementPayment;
use App\Tenancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OldStatementController extends BaseController
{
    public function store(Request $request)
    {
        $tenancy = Tenancy::withTrashed()->findOrFail($request->tenancy_id);
        $property = $tenancy->property;

        return dd($request->input());

        $statement = new Statement();
        $statement->period_start = $request->period_start ?? $tenancy->nextStatementDate();
        $statement->period_end = $request->period_end;
        $statement->amount = $request->amount;
        $statement->created_at = $statement->updated_at = $statement->paid_at = $statement->sent_at = $request->created_at;

        $tenancy->statements()->save($statement);

        if ($request->has('users')) {
        	$statement->users()->sync($request->users);
        } else {
        	$statement->users()->sync($property->owners);
        }

        // Invoice
        if ($request->invoice_number && count($request->item_name)) {
        	for ($i = 0; $i < count($request->item_name); $i++) {

        		if ($request->item_amount[$i]) {

	        		if (!$statement->invoice) {
	        			$invoice = new Invoice();
	        			$invoice->created_at = $invoice->updated_at = $invoice->sent_at = $request->created_at;
	        			$invoice->property_id = $property->id;
	        			$invoice->number = $request->invoice_number;
	        			$statement->storeInvoice($invoice);
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
        }

        // Expenses
        if (count($request->expense_name)) {
        	for ($i = 0; $i < count($request->expense_name); $i++) {
        		if ($request->expense_cost[$i]) {

        			$expense = new Expense();
        			$expense->contractor_id = $request->expense_contractor_id[$i];
        			$expense->name = $request->expense_name[$i];
        			$expense->cost = $request->expense_cost[$i];
        			$expense->created_at = $expense->paid_at = $request->created_at;

        			$property->expenses()->save($expense);

        			$statement->expenses()->attach($expense, ['amount' => $expense->cost]);
        		}
        	}
        }

        $statement->fresh();

        if ($invoice) {
            $payment = new StatementPayment();
            $payment->user_id = Auth::user()->id;
            $payment->statement_id = $statement->id;
            $payment->amount = $invoice->total;
            $payment->sent_at = $request->created_at;
            $payment->bank_account_id = get_setting('company_bank_account_id', null);

            // We attach the payment to the invoice statement payments
            // (as we want the invoice to become the parent)
            $payment = $invoice->statement_payments()->save($payment);

            // Attach the owners of the property to this payment as they have paid it.
            $payment->users()->attach($statement->tenancy->property->owners);
        }

        foreach ($statement->expenses as $expense) {
            $payment = new StatementPayment();
            $payment->user_id = Auth::user()->id;
            $payment->statement_id = $statement->id;
            $payment->amount = $expense->pivot->amount;
            $payment->sent_at = $request->created_at;

            $payment = $expense->payments()->save($payment);

            // Attach the contractors to the payment.
            $payment->users()->attach($expense->contractors);
        }

        $payment = new StatementPayment();
        $payment->user_id = Auth::user()->id;
        $payment->statement_id = $statement->id;
        $payment->amount = $statement->amount - $invoice->total;
        $payment->sent_at = $request->created_at;
        $payment->bank_account_id = $statement->property->bank_account_id;
        $payment->save();

        $this->successMessage('The old statement was created');
        return back();
    }
}