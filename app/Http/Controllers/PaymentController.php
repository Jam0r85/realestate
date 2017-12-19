<?php

namespace App\Http\Controllers;

use App\Events\DepositPaymentWasUpdated;
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

        if ($payment->present()->parentName == 'Deposit') {
            event(new DepositPaymentWasUpdated($payment));
        }

        return back();
    }
}
