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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = InvoiceGroup::latest()->paginate();        
        return view('invoice-groups.index', compact('groups'));
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

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InvoiceGroup  $group
     * @param  string $section
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceGroup $group, $section = 'layout')
    {    
        return view('invoice-groups.show.' . $section, compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateInvoiceGroupRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceGroupRequest $request, InvoiceGroup $group)
    {
        $group->name = $request->name;
        $group->branch_id = $request->branch_id;
        $group->next_number = $request->next_number;
        $group->format = $request->format;
        $group->save();

        return back();
    }
}
