<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\Http\Requests\StoreDepositPaymentRequest;
use App\Http\Requests\StoreDepositRequest;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deposits = Deposit::latest()->paginate();
        $title = 'Deposits List';

        return view('deposits.index', compact('title','deposits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepositRequest $request)
    {
        $deposit = new Deposit();
        $deposit->user_id = Auth::user()->id;
        $deposit->tenancy_id = $request->tenancy_id;
        $deposit->amount = $request->amount;
        $deposit->unique_id = $request->unique_id;
        $deposit->save();

        $this->successMessage('The deposit was created');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function show(Deposit $deposit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function edit(Deposit $deposit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deposit $deposit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deposit $deposit)
    {
        //
    }

    /**
     * Record a new deposit payment.
     * 
     * @param \App\Http\Request\StoreDepositPaymentRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function createDepositPayment(StoreDepositPaymentRequest $request, $id)
    {
        $service = new PaymentService();
        $payment = $service->createDepositPayment($request->input(), $id);

        $this->successMessage('The deposit payment was recorded');

        return back();
    }
}
