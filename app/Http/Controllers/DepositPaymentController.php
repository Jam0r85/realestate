<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\Events\DepositPaymentWasCreated;
use App\Http\Requests\DepositPaymentStoreRequest;
use App\Http\Requests\SearchRequest;
use Illuminate\Http\Request;

class DepositPaymentController extends BaseController
{
    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    public $model = 'App\Payment';

    /**
     * Store a new payment for the given deposit.
     * 
     * @param  \App\Http\Requests\DepositPaymentStoreRequest $request
     * @param  int  $deposit
     * @return \Illuminate\Http\Response
     */
    public function store(DepositPaymentStoreRequest $request, $id)
    {
        $deposit = Deposit::withTrashed()
            ->findOrFail($id);

        $payment = $this->repository
            ->fill($request->input());

        $deposit->storePayment($payment);

        event (new DepositPaymentWasCreated($payment));

        return back();
    }
}