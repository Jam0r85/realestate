<?php

namespace App\Http\Controllers;

use App\Events\Tenancies\TenancyUpdateStatus;
use App\Http\Requests\DestroyPaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentController extends BaseController
{
    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    public $model = 'App\Payment';

    /**
     * Find and display the payment.
     * 
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $section = 'layout')
    {
        $payment = $this->repository
            ->findOrFail($id);

        return view('payments.show.' . $section, compact('payment'));
    }

    /**
     * Update the payment in storage.
     * 
     * @param \App\Http\Requests\UpdatePaymentRequest $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentRequest $request, $id)
    {
        $payment = $this->repository
            ->findOrFail($id)
            ->fill($request->input())
            ->save();

        $payment->users()->sync($request->users);

        // Rent payment, we need to update the tenancy.
        // Better place to put this?
        if (class_basename($payment->parent) == 'Tenancy') {
            event(new TenancyUpdateStatus($payment->parent));
        }

        return back();
    }
}
