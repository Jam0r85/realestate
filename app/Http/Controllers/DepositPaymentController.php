<?php

namespace App\Http\Controllers;

use App\Deposit;
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
     * Search through the rent payments and display the results.
     * 
     * @param  \App\Http\Requests\SearchRequest  $request
     * @return  \Illuminate\Http\Response
     */
    public function search(SearchRequest $request)
    {
        $parent = parent::search($request);

        if (is_array($parent)) {

            $payments = $parent['payments'];

            $payments
                ->load('users','method','parent')
                ->where('parent_type', 'deposits');

            $parent['payments'] = $payments;
        }

        return $parent;
    }

    /**
     * Store a new payment for the given deposit.
     * 
     * @param  \App\Http\Requests\DepositPaymentStoreRequest $request
     * @param  \App\Deposit  $deposit
     * @return  \Illuminate\Http\Response
     */
    public function store(DepositPaymentStoreRequest $request, Deposit $deposit)
    {
        $payment = $this->repository;
        $payment->amount = $request->amount;
        $payment->payment_method_id = $request->payment_method_id;
        $payment->note = $request->note;

        $deposit->storePayment($payment);
        return back();
    }
}