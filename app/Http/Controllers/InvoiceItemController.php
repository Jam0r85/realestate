<?php

namespace App\Http\Controllers;

use App\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceItemController extends Controller
{
	/**
	 * Show the form for editing an invoice item.
	 * 
	 * @param  \App\InvoiceItem 	$id
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
     * @param  \Illuminate\Http\Request  	$request
     * @param  \App\InvoiceItem  			$id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	$item = InvoiceItem::findOrFail($id);
    	$item->fill($request->input());
    	$item->save();

    	flash('The invoice item was updated')->success();
        return back();
    }
}
