<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceItemRequest;
use App\Http\Requests\StoreInvoicePaymentRequest;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Invoice;
use App\Services\PaymentService;
use App\Services\InvoiceService;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $invoices = Invoice::where('due_at', '<=', Carbon::now())
            ->whereNull('paid_at')
            ->latest()
            ->paginate();            
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
        $invoice = Invoice::findOrFail($id);
        $invoice->fill($request->input());
        $invoice->save();

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
     * @param  \App\Http\Requests\StoreInvoicePaymentRequest    $request
     * @param  \App\Invoice                                     $id
     * @return\Illuminate\Http\Responce
     */
    public function createPayment(StoreInvoicePaymentRequest $request, $id)
    {
        $service = new PaymentService();
        $service->createInvoicePayment($request->input(), $id);

        $this->successMessage('Payment was recorded');

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
