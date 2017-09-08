<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceItemRequest;
use App\Http\Requests\StoreInvoicePaymentRequest;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Invoice;
use App\Services\InvoiceService;
use App\Services\PaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InvoiceController extends BaseController
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::whereNotNull('paid_at')->latest()->paginate();
        $unpaid_invoices = Invoice::whereNull('paid_at')->latest()->get();

        $invoices->load('property','users','items','items.taxRate','payments','statement_payments');
        $unpaid_invoices->load('property','users','items','items.taxRate','payments','statement_payments');

        $title = 'Invoices List';

        return view('invoices.index', compact('invoices','unpaid_invoices','title'));
    }

    /**
     * Search through the invoices and display the results.
     * 
     * @param  \Illuminate\Http|Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Clear the search term.
        if ($request && $request->has('clear_search')) {
            Session::forget('invoices_search_term');
            return redirect()->route('invoices.index');
        }

        Session::put('invoices_search_term', $request->search_term);

        $invoices = Invoice::search(Session::get('invoices_search_term'))->get();
        $title = 'Search Results';

        return view('invoices.index', compact('invoices','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invoices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceRequest $request)
    {
        $service = new InvoiceService();
        $invoice = $service->createInvoice($request->input());

        $this->successMessage('The invoice was created');

        return redirect()->route('invoices.show', $invoice->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id, $section = 'layout')
    {
        $invoice = Invoice::withTrashed()->findOrFail($id);
        return view('invoices.show.' . $section, compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceRequest $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->fill($request->input());
        $invoice->save();

        $invoice->users()->sync($request->input('users'));

        $this->successMessage('The invoice was updated');

        return back();
    }

    /**
     * Store a new invoice item to the invoice.
     * 
     * @param   \App\Http\Requests\StoreInvoiceItemRequest  $request
     * @param   \App\Invoice                                $id
     * @return  \Illuminate\Http\Response
     */
    public function createItem(StoreInvoiceItemRequest $request, $id)
    {
        $service = new InvoiceService();
        $service->createInvoiceItem($request->input(), $id);

        $this->successMessage('The invoice item was created');

        return redirect()->route('invoices.show', $id);
    }

    /**
     * Store a new payment for the invoice.
     * 
     * @param \App\Http\Requests\StoreInvoicePaymentRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Responce
     */
    public function createPayment(StoreInvoicePaymentRequest $request, $id)
    {
        $service = new PaymentService();
        $service->createInvoicePayment($request->input(), $id);

        $this->successMessage('Payment was recorded');

        return back();
    }

    /**
     * Archive an invoice in storage.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        $this->successMessage('The invoice was archived');

        return back();
    }

    /**
     * Restore an invoice in storage.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $invoice = Invoice::withTrashed()->findOrFail($id);
        $invoice->restore();

        $this->successMessage('The invoice was restored');

        return back();
    }
}
