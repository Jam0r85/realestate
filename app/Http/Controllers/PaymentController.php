<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyPaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentController extends BaseController
{
    /**
     * Create a new controller instance.
     * 
     * @return  void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of all rent payments received.
     *
     * @return \Illuminate\Http\Response
     */
    public function rentPayments()
    {
        $payments = Payment::where('parent_type', 'tenancies')->latest()->paginate();
        $title = 'Rent Payments';

        return view('payments.rent', compact('payments','title'));
    }

    /**
     * Search through the resource and display the results.
     * 
     * @param  \Illuminate\Http\Requests $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Clear the search term.
        if ($request && $request->has('clear_search')) {
            Session::forget('payments_search_term');
            return back();
        }

        Session::put('payments_search_term', $request->search_term);

        $payments = Payment::search(Session::get('payments_search_term'))->get();
        $payments->sortByDesc('created_at');
        $title = 'Search Results';

        return view('payments.rent', compact('payments','title'));
    }

    /**
     * Find and display the payment.
     * 
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $section = 'layout')
    {
        $payment = Payment::findOrFail($id);
        return view('payments.show.' . $section, compact('payment'));
    }

    /**
     * Update the payment in storage.
     * 
     * @param \App\Http\Requests\UpdatePaymentRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentRequest $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->created_at = $request->created_at;
        $payment->amount = $request->amount;
        $payment->payment_method_id = $request->payment_method_id;
        $payment->save();

        $this->successMessage('The payment was updated');

        return back();
    }

    /**
     * Destroy the given payment.
     * 
     * @param \App\Http\Requests\DestroyPaymentRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyPaymentRequest $request, $id)
    {
        $payment = Payment::findOrFail($id);

        if ($request->confirmation != $payment->id) {
            $this->errorMessage("The ID was incorrect");
            return back();
        }

        $payment->delete();

        $this->successMessage('The payment ' . $payment->id . ' was deleted');

        return back();
    }
}
