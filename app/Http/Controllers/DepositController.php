<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\Http\Requests\DepositStorePaymentRequest;
use App\Http\Requests\DepositUpdateRequest;
use App\Http\Requests\StoreDepositRequest;
use App\Payment;
use App\Services\PaymentService;
use App\Tenancy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DepositController extends BaseController
{
    /**
     * Display a listing of deposits.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deposits = Deposit::with('payments','owner','tenancy')->latest()->paginate();
        $deposit_balance = Deposit::all()->sum('balance');
        $title = 'Deposits List';

        return view('deposits.index', compact('title','deposits','deposit_balance'));
    }

    /**
     * Search through the deposits and display the results.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Clear the search term.
        if ($request && $request->has('clear_search')) {
            Session::forget('deposit_search_term');
            return redirect()->route('deposit.index');
        }

        Session::put('deposit_search_term', $request->search_term);

        $deposits = Deposit::search(Session::get('deposit_search_term'))->get();
        $title = 'Search Results';

        return view('deposits.index', compact('deposits', 'title'));
    }

    /**
     * Store a newly create deposit in storage.
     *
     * @param \App\Http\Requests\StoreDepositRequest $request
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

        $this->successMessage('The deposit of ' . $deposit->amount . ' was created');

        return back();
    }

    /**
     * Update the deposit in storage.
     *
     * @param \App\Http\Requests\DepositUpdateRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepositUpdateRequest $request, $id)
    {
        $deposit = Deposit::findOrFail($id);

        $deposit->unique_id = $request->unique_id;
        $deposit->amount = $request->amount;
        $deposit->save();

        $this->successMessage('The deposit was updated');

        return back();
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
     * @param \App\Http\Request\DepositStorePaymentRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function createDepositPayment(DepositStorePaymentRequest $request, $id)
    {
        $deposit = Deposit::findOrFail($id);

        $payment = new Payment();
        $payment->user_id = Auth::user()->id;
        $payment->key = str_random(30);
        $payment->amount = $request->amount;
        $payment->payment_method_id = $request->payment_method_id;
        $payment->note = $request->note;

        if ($request->created_at) {
            $payment->created_at = $payment->updated_at = Carbon::createFromFormat('Y-m-d', $request->created_at);
        }

        $deposit->payments()->save($payment);

        $this->successMessage('The deposit payment of ' . $payment->amount . ' was recorded');

        if ($request->has('record_into_rent')) {
            $tenancy = Tenancy::findOrFail($deposit->tenancy_id);

            $rent_payment = new Payment();
            $rent_payment->user_id = Auth::user()->id;
            $rent_payment->amount = abs($request->amount);
            $rent_payment->payment_method_id = 9;
            $rent_payment->note = 'Payment from the Deposit';
        
            $tenancy->rent_payments()->save($rent_payment);

            $this->successMessage('The payment of ' . $rent_payment->amount . 'was recorded as rent for the tenancy ' . $tenancy->name);
        }

        return back();
    }
}
