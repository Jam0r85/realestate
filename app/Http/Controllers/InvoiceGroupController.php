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
     * The eloquent model for this controller.
     * 
     * @var  string
     */
    public $model = 'App\InvoiceGroup';

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
     * @param  \App\Http\Requests\StoreInvoiceGroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceGroupRequest $request)
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
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInvoiceGroupRequest  $request
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceGroupRequest $request, $id)
    {
        $this->repository
            ->withTrashed()
            ->findOrFail($id)
            ->fill($request->input())
            ->save();

        return back();
    }
}
