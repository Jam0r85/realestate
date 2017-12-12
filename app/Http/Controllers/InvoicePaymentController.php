<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoicePaymentStoreRequest;
use App\Invoice;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InvoicePaymentController extends BaseController
{
    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    public $model = 'App\Payment';

    /**
     * Store a new invoice payment in storage.
     * 
     * @param \App\Http\Requests\InvoicePaymentStoreRequest $request
     * @param integer $id invoice_id
     * @return \Illuminate\Http\Response
     */
    public function store(InvoicePaymentStoreRequest $request, $id)
    {
    	$invoice = Invoice::withTrashed()->findOrFail($id);

    	$payment = $this->repository;
    	$payment->amount = $request->amount;
    	$payment->payment_method_id = $request->payment_method_id;
    	$payment->note = $request->note;

    	$invoice->payments()->save($payment);

    	$payment->users()->attach($invoice->users);

    	return back();
    }
}