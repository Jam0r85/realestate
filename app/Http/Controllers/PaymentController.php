<?php

namespace App\Http\Controllers;

use App\Events\Tenancies\TenancyUpdateStatus;
use App\Http\Requests\DestroyPaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentController extends BaseController
{
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
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $payment->created_at = $request->created_at;
        $payment->amount = $request->amount;
        $payment->payment_method_id = $request->payment_method_id;
        $payment->save();

        $payment->users()->sync($request->users);

        // Rent payment, we need to update the tenancy.
        // Better place to put this?
        if (class_basename($payment->parent) == 'Tenancy') {
            event(new TenancyUpdateStatus($payment->parent));
        }

        return back();
    }

    /**
     * Destroy the given payment.
     * 
     * @param \App\Http\Requests\DestroyPaymentRequest $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyPaymentRequest $request, Payment $payment)
    {
        $payment->delete();
        return redirect()->route('rent-payments.index');
    }
}
