<?php

namespace App\Http\Controllers;

use App\Http\Requests\RentPaymentStoreRequest;
use App\Payment;
use App\Tenancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentPaymentController extends BaseController
{
	/**
	 * Store a rent payment into storage.
	 * 
	 * @param \App\Http\Requests\RentPaymentStoreRequest $request
	 * @param integer $id tenancy_id
	 * @return \Illuminate\Http\Response
	 */
    public function store(RentPaymentStoreRequest $request, $id)
    {
    	$tenancy = Tenancy::withTrashed()->findOrFail($id);

    	$payment = new Payment();
    	$payment->amount = $request->amount;
    	$payment->payment_method_id = $request->payment_method_id;
    	$payment->note = $request->note;

    	$tenancy->rent_payments()->save($payment);

    	$payment->users()->attach($tenancy->tenants);

    	$this->successMessage('The payment of ' . $payment->amount . ' was recorded against ' . $tenancy->name);
    	return back();
    }
}
