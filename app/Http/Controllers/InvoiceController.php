<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceItemRequest;
use App\Http\Requests\StoreInvoicePaymentRequest;
use App\Http\Requests\StoreInvoiceRequest;
use App\Repositories\EloquentInvoicesRepository;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * @var  App\Repositories\EloquentInvoicesRepository
     */
    protected $invoices;

    /**
     * Create a new controller instance.
     * 
     * @param   EloquentInvoicesRepository $invoices
     * @return  void
     */
    public function __construct(EloquentInvoicesRepository $invoices)
    {
        $this->middleware('auth');
        $this->invoices = $invoices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = $this->invoices->getAllPaged();
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
        $invoices = $this->invoices->getUnpaidPaged();
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
        $invoices = $this->invoices->getOverduePaged();
        $title = 'Overdue Invoices';
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
        $invoice = $this->invoices->createInvoice($request->input());
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
        $invoice = $this->invoices->find($id);
        return view('invoices.show.' . $section, compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
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
        return back();
    }
}
