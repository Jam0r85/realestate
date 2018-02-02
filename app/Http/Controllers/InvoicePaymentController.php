<?php

namespace App\Http\Controllers;

use App\Events\InvoicePaymentWasCreated;
use App\Http\Requests\InvoicePaymentStoreRequest;
use App\Invoice;
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
     * @param  \App\Http\Requests\InvoicePaymentStoreRequest  $request
     * @param  int  $invoice
     * @return \Illuminate\Http\Response
     */
    public function store(InvoicePaymentStoreRequest $request, $id)
    {
    	$invoice = Invoice::withTrashed()
            ->findOrFail($id);

    	$payment = $this->repository
            ->fill($request->input());

    	$invoice
            ->storePayment($payment);

        event(new InvoicePaymentWasCreated($payment));

    	return back();
    }
}