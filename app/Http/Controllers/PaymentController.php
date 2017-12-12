<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePaymentRequest;
use Illuminate\Http\Request;

class PaymentController extends BaseController
{
    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    public $model = 'App\Payment';

    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $payments = $this->repository
            ->filter($request->all())
            ->latest()
            ->paginateFilter();

        return view('payments.index', compact('payments'));
    }

    /**
     * Find and display the payment.
     * 
     * @param  integer $id
     * @return  \Illuminate\Http\Response
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
     * @param  \App\Http\Requests\UpdatePaymentRequest  $request
     * @param  \App\Payment  $payment
     * @return  \Illuminate\Http\Response
     */
    public function update(UpdatePaymentRequest $request, $id)
    {
        $this->repository
            ->findOrFail($id)
            ->fill($request->input())
            ->save();

        $this->repository
            ->findOrFail($id)
            ->users()
            ->sync($request->users);            

        return back();
    }
}
