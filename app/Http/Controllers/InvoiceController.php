<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyInvoiceRequest;
use App\Http\Requests\InvoiceStoreRequest;
use App\Http\Requests\StoreInvoiceItemRequest;
use App\Http\Requests\StoreInvoicePaymentRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Invoice;
use App\InvoiceGroup;
use App\Services\InvoiceService;
use App\Services\PaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InvoiceController extends BaseController
{
    /**
     * Display a list of invoices.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->all()) {
            $request->request->add(['unpaid' => true]);
        }

        $invoices = Invoice::with('invoiceGroup','property','users','items','items.taxRate','statement_payments','statements')
            ->withTrashed()
            ->filter($request->all())
            ->paginateFilter();

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Search through the invoices and display the results.
     * 
     * @param  \Illuminate\Http|Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Clear the search term.
        if ($request && $request->has('clear_search')) {
            Session::forget('invoices_search_term');
            return redirect()->route('invoices.index');
        }

        Session::put('invoices_search_term', $request->search_term);

        $invoices = Invoice::search(Session::get('invoices_search_term'))->get();
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
     * @param \App\Http\Requests\InvoiceStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceStoreRequest $request)
    {
        $invoiceGroup = InvoiceGroup::findOrFail($request->invoice_group_id);

        $invoice = new Invoice();
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
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id, $section = 'layout')
    {
        $invoice = Invoice::withTrashed()->findOrFail($id);
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
        
        $invoice->property_id = $request->property_id;
        $invoice->created_at = $request->created_at;
        $invoice->due_at = $request->due_at;
        $invoice->paid_at = $request->has('paid_at') ? $request->paid_at : null;
        $invoice->number = $request->number;
        $invoice->recipient = $request->recipient;
        $invoice->terms = $request->terms;
        $invoice->save();

        $invoice->users()->sync($request->input('users'));
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

        return redirect()->route('invoices.show', $id);
    }

    /**
     * Archive an invoice in storage.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return back();
    }

    /**
     * Restore an invoice in storage.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $invoice = Invoice::withTrashed()->findOrFail($id);
        $invoice->restore();

        return back();
    }

    /**
     * Destroy an invoice from storage.
     * 
     * @param \App\Http\Requests\DestroyInvoiceRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyInvoiceRequest $request, $id)
    {
        $invoice = Invoice::withTrashed()->findOrFail($id);

        $invoice->items()->delete();
        $invoice->forceDelete();

        return redirect()->route('invoices.index');
    }

    /**
     * Clone the given invoice.
     * 
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function clone($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->clone();

        return back();
    }

    /**
     * Send this invoice to it's users.
     * 
     * @param  Request $request [description]
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->send();

        return back();
    }
}
