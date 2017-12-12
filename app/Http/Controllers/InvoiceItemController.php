<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateInvoiceItemRequest;
use App\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceItemController extends BaseController
{
    public $model = 'App\InvoiceItem';

	/**
	 * Show the form for editing an invoice item.
	 * 
	 * @param integer $id
	 * @return \Illuminate\Http\Responce
	 */
    public function edit($id)
    {
        $item = $this
            ->repository
            ->findOrFail($id);

    	return view('invoices.show.edit-item', compact('item'));
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
        $this
            ->repository
            ->findOrFail($id)
            ->fill($request->input())
            ->save();

        return back();
    }

    /**
     * Remove an invoice item from storage.
     * 
     * @param  InvoiceItem  $item
     * @return  \Illuminate\Http\Response
     */
    public function delete(InvoiceItem $item)
    {
        $item->delete();
        return redirect()->route('invoices.show', $item->invoice_id);
    }
}
