<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\Http\Requests\DepositPaymentStoreRequest;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DepositPaymentController extends BaseController
{
    /**
     * Display a listing of deposit payments received.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::with('users','method','parent')
            ->forDeposit()
            ->latest()
            ->paginate();

        $title = 'Deposit Payments';
        return view('payments.deposit', compact('payments','title'));
    }

    /**
     * Search through the deposit payments and display the results.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Clear the search term.
        if ($request && $request->has('clear_search')) {
            Session::forget('deposit_payments_search_term');
            return redirect()->route('deposit-payments.index');
        }

        Session::put('deposit_payments_search_term', $request->search_term);

        $payments = Payment::search(Session::get('deposit_payments_search_term'))
            ->get();

        $payments->load('users','method','parent');

        // Filter the payments for a parent_type of deposit.
        $payments = $payments->where('parent_type', 'deposits');

        $title = 'Search Results';
        return view('payments.deposit', compact('payments','title'));
    }

    /**
     * Store a new payment for the given deposit.
     * 
     * @param \App\Http\Requests\DepositPaymentStoreRequest $request
     * @param  \App\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function store(DepositPaymentStoreRequest $request, Deposit $deposit)
    {
        $payment = new Payment();
        $payment->amount = $request->amount;
        $payment->payment_method_id = $request->payment_method_id;
        $payment->note = $request->note;

        $deposit->storePayment($payment);
        return back();
    }
}