<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyInvoiceRequest;
use App\Http\Requests\InvoiceStoreRequest;
use App\Http\Requests\StoreInvoiceItemRequest;
use App\Http\Requests\StoreInvoicePaymentRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\InvoiceGroup;
use App\Services\InvoiceService;
use App\Services\PaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InvoiceController extends BaseController
{
    public $model = 'App\Invoice';

    /**
     * Display a list of invoices.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->all()) {
            $request->request->add(['paid' => false]);
        }

        $invoices = $this->repository
            ->with('invoiceGroup','property','users','items','items.taxRate','statementPayments','statements')
            ->withTrashed()
            ->filter($request->all())
            ->latest()
            ->paginateFilter();

        return view('invoices.index', compact('invoices'));
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
     * @param \App\Http\Requests\InvoiceStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceStoreRequest $request)
    {
        $invoiceGroup = InvoiceGroup::findOrFail($request->invoice_group_id);

        $invoice = $this->repository;
        $invoice->property_id = $request->property_id;
        $invoice->number = $request->number;
        $invoice->terms = $request->terms;

        $invoiceGroup->storeInvoice($invoice);

        if ($request->has('users')) {
            $invoice->users()->attach($request->users);
        }
        
        return redirect()->route('invoices.show', $invoice->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $show = 'index')
    {
        $invoice = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('invoices.show', compact('invoice','show'));
    }

    /**
     * Display the form to edit the specified resource.
     *
     * @param  int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('invoices.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return  \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceRequest $request, $id)
    {
        $invoice = $this->repository
            ->findOrFail($id);

        $invoice
            ->fill($request->input())
            ->save();

        if ($request->has('users')) {
            $invoice
                ->users()->sync($request->input('users'));
        }

        return back();
    }

    /**
     * Clone the given invoice.
     * 
     * @param  \App\Invoice  $id
     * @return  \Illuminate\Http\Response
     */
    public function clone($id)
    {
        $this->repository
            ->findOrFail($id)
            ->clone();

        return back();
    }

    /**
     * Send this invoice to it's users.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $id
     * @return  \Illuminate\Http\Response
     */
    public function send(Request $request, $id)
    {
        $invoice = $this->repository
            ->findOrFail($id)
            ->send();

        return back();
    }
}
