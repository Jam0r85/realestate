<?php

namespace App\Http\Controllers;

use App\Events\DepositPaymentWasDeleted;
use App\Events\DepositPaymentWasUpdated;
use App\Events\InvoicePaymentWasDeleted;
use App\Events\RentPaymentWasDeleted;
use App\Events\RentPaymentWasUpdated;
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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $payments = $this->repository
            ->with('method','users','parent')
            ->filter($request->all())
            ->latest()
            ->paginateFilter();

        return view('payments.index', compact('payments'));
    }

    /**
     * Display the specified resource.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = $this->repository
            ->findOrFail($id);

        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = $this->repository
            ->findOrFail($id);

        return view('payments.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \App\Http\Requests\UpdatePaymentRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentRequest $request, $id)
    {
        $payment = $this->repository
            ->findOrFail($id);

        $payment
            ->fill($request->input())
            ->save();

        if ($request->has('users')) {
            $payment
                ->users()
                ->sync($request->users);
        }

        if (model_name($payment->parent) == 'Deposit') {
            event(new DepositPaymentWasUpdated($payment));
        }

        if (model_name($payment->parent) == 'Tenancy') {
            event (new RentPaymentWasUpdated($payment));
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $payment = parent::destroy($request, $id);

        if (model_name($payment->parent) == 'Invoice') {
            event(new InvoicePaymentWasDeleted($payment));
        }   

        if (model_name($payment->parent) == 'Tenancy') {
            event(new RentPaymentWasDeleted($payment));
        }

        if (model_name($payment->parent) == 'Deposit') {
            event(new DepositPaymentWasDeleted($payment));
        }

        return redirect()->route($this->indexView);
    }
}
