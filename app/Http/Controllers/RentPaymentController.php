<?php

namespace App\Http\Controllers;

use App\Http\Requests\RentPaymentStoreRequest;
use App\Payment;
use App\Tenancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RentPaymentController extends BaseController
{
    /**
     * Display a listing of rent payments received.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::with('users','method','parent')
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
            return redirect()->route('payments.rent');
        }

        Session::put('rent_payments_search_term', $request->search_term);

        $payments = Payment::with('users','method','parent')
            ->ForRent()
            ->search(Session::get('rent_payments_search_term'))
            ->get();

        $title = 'Search Results';
        return view('users.index', compact('payments','title'));
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
    	$payment->amount = $request->amount;
    	$payment->payment_method_id = $request->payment_method_id;
    	$payment->note = $request->note;

    	$tenancy->rent_payments()->save($payment);

    	$payment->users()->attach($tenancy->tenants);

    	$this->successMessage('The payment of ' . $payment->amount . ' was recorded against ' . $tenancy->name);
    	return back();
    }
}
