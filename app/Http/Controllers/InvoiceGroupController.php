<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceGroupRequest;
use App\Http\Requests\UpdateInvoiceGroupRequest;
use App\InvoiceGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class InvoiceGroupController extends BaseController
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
     * Display the form for creating a new resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invoice-groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreInvoiceGroupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceGroupRequest $request)
    {
        $group = new InvoiceGroup();
        $group->name = $request->name;
        $group->branch_id = $request->branch_id;
        $group->next_number = $request->next_number;
        $group->format = $request->format;
        $group->save();

        Cache::tags(['invoice_groups'])->flush();

        $this->successMessage('The invoice group "' . $group->name . '" was created');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @param string $section
     * @return \Illuminate\Http\Response
     */
    public function show($id, $section = 'layout')
    {
        $group = InvoiceGroup::findOrFail($id);        
        return view('invoice-groups.show.' . $section, compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateInvoiceGroupRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceGroupRequest $request, $id)
    {
        $group = InvoiceGroup::findOrFail($id);
        $group->name = $request->name;
        $group->branch_id = $request->branch_id;
        $group->next_number = $request->next_number;
        $group->format = $request->format;
        $group->save();

        Cache::tags(['invoice_groups'])->flush();

        $this->successMessage('The invoice group "' . $group->name . '" was updated');

        return back();
    }
}
