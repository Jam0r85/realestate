<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceGroupRequest;
use App\Http\Requests\UpdateInvoiceGroupRequest;
use App\InvoiceGroup;
use Illuminate\Http\Request;

class InvoiceGroupController extends Controller
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
        $invoice_groups = InvoiceGroup::latest()->paginate();
        $invoice_groups->load('invoices','invoices.items','invoices.items.taxRate');
        
        return view('invoice-groups.index', compact('invoice_groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceGroupRequest $request)
    {
        $this->invoice_groups->create($request->input());
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InvoiceGroup  $invoiceGroup
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice_group = $this->invoice_groups->find($id);
        return view('invoice-groups.show', compact('invoice_group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InvoiceGroup  $invoiceGroup
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice_group = $this->invoice_groups->find($id);
        return view('invoice-groups.edit', compact('invoice_group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InvoiceGroup  $invoiceGroup
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceGroupRequest $request, $id)
    {
        $this->invoice_groups->update($request->input(), $id);
        return back();
    }
}
