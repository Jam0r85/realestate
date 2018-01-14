<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceGroup\InvoiceGroupStoreRequest;
use App\Http\Requests\InvoiceGroup\InvoiceGroupUpdateRequest;
use Illuminate\Http\Request;

class InvoiceGroupController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = $this->repository
            ->orderBy('name')
            ->paginate();

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
     * @param  \App\Http\Requests\InvoiceGroupStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceGroupStoreRequest $request)
    {
        $group = $this->repository
            ->fill($request->input())
            ->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $show
     * @return \Illuminate\Http\Response
     */
    public function show($id, $show = 'index')
    {
        $group = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('invoice-groups.show', compact('group','show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('invoice-groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\InvoiceGroupUpdateRequest  $request
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceGroupUpdateRequest $request, $id)
    {
        $this->repository
            ->withTrashed()
            ->findOrFail($id)
            ->fill($request->input())
            ->save();

        return back();
    }
}
