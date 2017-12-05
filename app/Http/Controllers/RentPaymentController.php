<?php

namespace App\Http\Controllers;

use App\Http\Requests\RentPaymentStoreRequest;
use App\Notifications\TenantRentPaymentReceived;
use App\Payment;
use App\Tenancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class RentPaymentController extends BaseController
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
     * Display a listing of rent payments received.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::with('users','method','parent','parent.tenants')
            ->forRent()
            ->latest()
            ->paginate();

        $title = 'Rent Payments';
        return view('payments.rent', compact('payments','title'));
    }

    /**
     * Search through the rent payments and display the results.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Clear the search term.
        if ($request && $request->has('clear_search')) {
            Session::forget('rent_payments_search_term');
            return redirect()->route('rent-payments.index');
        }

        Session::put('rent_payments_search_term', $request->search_term);

        $payments = Payment::search(Session::get('rent_payments_search_term'))
            ->get();

        $payments->load('users','method','parent');

        // Filter the payments for a parent_type of tenancy.
        $payments = $payments->where('parent_type', 'tenancies');

        $title = 'Search Results';
        return view('payments.rent', compact('payments','title'));
    }

	/**
	 * Store a rent payment into storage.
	 * 
	 * @param \App\Http\Requests\RentPaymentStoreRequest $request
	 * @param integer $id tenancy_id
	 * @return \Illuminate\Http\Response
	 */
    public function store(RentPaymentStoreRequest $request, $id)
    {
    	$tenancy = Tenancy::withTrashed()->findOrFail($id);

    	$payment = new Payment();
    	$payment->amount = $request->amount ?? $tenancy->currentRent->amount;
    	$payment->payment_method_id = $request->payment_method_id;
    	$payment->note = $request->note;

    	$tenancy->rent_payments()->save($payment);

    	$payment->users()->attach($tenancy->tenants);

        if ($request->has('send_notifications')) {
            Notification::send($payment->users, new TenantRentPaymentReceived($payment));
        }

    	$this->successMessage('The payment of ' . currency($payment->amount) . ' was recorded for the tenancy ' . $tenancy->name);
    	return back();
    }

    /**
     * Show a printable version of payments received.
     * 
     * @param  Tenancy  $tenancy
     * @return  Illuminate\Http\Response
     */
    public function print(Tenancy $tenancy)
    {
        return view('rent-payments.print', compact('tenancy'));
    }

    /**
     * Show a printable version of payments received with statements.
     * 
     * @param  Tenancy  $tenancy
     * @return  Illuminate\Http\Response
     */
    public function printWithStatements(Tenancy $tenancy)
    {
        $payments = $tenancy->rent_payments;
        $statements = $tenancy->statements;

        $merged = $payments->merge($statements);
        $merged = $merged->sortBy('created_at');

        $balance = 0;

        foreach ($merged as $item) {

            $item->name = class_basename($item);

            if (class_basename($item) == 'Payment') {
                $item->other = $item->method->name;
                $balance = $balance + $item->amount;
            } elseif (class_basename($item) == 'Statement') {
                $item->other = $item->present()->period;
                $balance = $balance - $item->amount;
            }

            $item->balance = $balance;
        }

        return view('rent-payments.print-with-statements', compact('tenancy','merged'));
    }
}
