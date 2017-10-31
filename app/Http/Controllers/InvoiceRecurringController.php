<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceRecurring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceRecurringController extends BaseController
{
	/**
	 * Store a new recurring invoice in storage.
	 * 
	 * @param
	 * @param integer $id invoice_id
	 * @return \Illuminate\Http\Response
	 */
    public function store(Request $request, $id)
    {
    	$invoice = Invoice::findOrFail($id);

    	$recur = new InvoiceRecurring();
    	$recur->user_id = Auth::user()->id;
    	$recur->next_invoice = $request->next_invoice;
    	$recur->ends_at = $request->ends_at;
    	$recur->interval_type = $request->interval_type;
    	$recur->interval = $request->interval;

    	$invoice->recurring()->save($recur);

    	$this->successMessage('Invoice ' . $invoice->name . ' will now recur');
    	return back();
    }
}
