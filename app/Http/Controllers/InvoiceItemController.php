<?php

namespace App\Http\Controllers;

use App\Events\InvoiceItemWasDeleted;
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
     * The index view
     */
    public $indexView = null;

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
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceItemRequest $request)
    {
        $invoice = Invoice::withTrashed()->findOrFail($request->invoice_id);

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $item = parent::destroy($request, $id);

        event(new InvoiceItemWasDeleted($item));
        
        return redirect()->route('invoices.show', $item->invoice_id);
    }
}
