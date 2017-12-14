<?php

namespace App\Http\Controllers;

use App\Events\InvoiceItemWasUpdated;
use App\Http\Requests\StoreInvoiceItemRequest;
use App\Http\Requests\UpdateInvoiceItemRequest;
use App\Invoice;
use Illuminate\Http\Request;

class InvoiceItemController extends BaseController
{
    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    public $model = 'App\InvoiceItem';

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function create(Invoice $invoice)
    {
        return view('invoice-items.create', compact('invoice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInvoiceItemRequest  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceItemRequest $request, Invoice $invoice)
    {
        $item = $this->repository
            ->fill($request->input());

        $invoice->storeItem($item);
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->repository
            ->findOrFail($id);

        return view('invoice-items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInvoiceItemRequest $request
     * @param  \App\InvoiceItem $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceItemRequest $request, $id)
    {
        $item = $this
            ->repository
            ->findOrFail($id);

        $item
            ->fill($request->input())
            ->save();

        event(new InvoiceItemWasUpdated($item));

        return back();
    }
}
