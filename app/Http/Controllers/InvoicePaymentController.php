<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InvoicePaymentController extends Controller
{
    /**
     * Display a listing of invoice payments received.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::with('users','method','parent')
            ->forInvoice()
            ->latest()
            ->paginate();

        $title = 'Invoice Payments';
        return view('payments.invoice', compact('payments','title'));
    }

    /**
     * Search through the invoice payments and display the results.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Clear the search term.
        if ($request && $request->has('clear_search')) {
            Session::forget('invoice_payments_search_term');
            return redirect()->route('invoice-payments.index');
        }

        Session::put('invoice_payments_search_term', $request->search_term);

        $payments = Payment::search(Session::get('invoice_payments_search_term'))
            ->get();

        $payments->load('users','method','parent');

        $title = 'Search Results';
        return view('payments.invoice', compact('payments','title'));
    }
}