<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceItemRequest;
use App\Http\Requests\StoreInvoicePaymentRequest;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public $invoice_service;

    /**
     * Create a new controller instance.
     * 
     * @return  void
     */
    public function __construct(InvoiceService $invoice_service)
    {
        $this->middleware('auth');
        $this->invoice_service = $invoice_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::whereNotNull('paid_at')->latest()->paginate();
        $title = 'Invoices List';

        return view('invoices.index', compact('invoices','title'));
    }

    /**
     * Display a listing of unpaid invoices.
     *
     * @return \Illuminate\Http\Response
     */
    public function unpaid()
    {
        $invoices = Invoice::whereNull('paid_at')->latest()->paginate();
        $title = 'Unpaid Invoices';

        return view('invoices.index', compact('invoices','title'));
    }

    /**
     * Display a listing of overdue invoices.
     *
     * @return \Illuminate\Http\Response
     */
    public function overdue()
    {
        $invoices = Invoice::where('due_at', '<=', Carbon::now())->whereNull('paid_at')->latest()->paginate();
        $title = 'Overdue Invoices';

        return view('invoices.index', compact('invoices','title'));
    }

    /**
     * Search through the invoices and display the results.
     * 
     * @param  \Illuminate\Http|Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $invoices = Invoice::search($request->search_term)->get();
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
        $invoice = $this->invoice_service->createInvoice($request->input());
        return redirect()->route('invoices.show', $invoice->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id, $section = 'items')
    {
        $invoice = Invoice::findOrFail($id);
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
        $this->invoices->updateInvoice($request->input(), $id);
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
        $this->invoices->createInvoiceItem($request->input(), $id);
        return redirect()->route('invoices.show', $id);
    }

    /**
     * Store a new payment for the invoice.
     * 
     * @param  \App\Http\Requests\StoreInvoicePaymentRequest    $request
     * @param  \App\Invoice                                     $id
     * @return\Illuminate\Http\Responce
     */
    public function createPayment(StoreInvoicePaymentRequest $request, $id)
    {
        $this->invoices->createPayment($request->input(), $id);
        return back();
    }

    /**
     * Archive the specified resource in storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $this->invoices->archive($id);
        $this->invoices->resetGroupNextNumber($id);

        return back();
    }
}
