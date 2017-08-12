<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateInvoiceItemRequest;
use App\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceItemController extends BaseController
{
	/**
	 * Show the form for editing an invoice item.
	 * 
	 * @param integer $id
	 * @return \Illuminate\Http\Responce
	 */
    public function edit($id)
    {
    	$item = InvoiceItem::findOrFail($id);
    	return view('invoices.show.edit-item', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateInvoiceItemRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceItemRequest $request, $id)
    {
    	$item = InvoiceItem::findOrFail($id);

        if ($request->has('remove_item')) {
            $item->delete();
            $this->successMessage('The item was removed');
        } else {
        	$item->fill($request->input());
        	$item->save();
            $this->successMessage('The item was updated');
        }

        return back();
    }
}
