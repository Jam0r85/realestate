<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
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
        $payments = Payment::latest()->paginate();
        $title = 'Rent Payments';

        return view('payments.index', compact('payments','title'));
    }

    /**
     * Search through the resource and display the results.
     * 
     * @param  \Illuminate\Http\Requests $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $payments = Payment::search($request->search_term)->get();
        $title = 'Search Results';

        return view('payments.index', compact('payments','title'));
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
}
