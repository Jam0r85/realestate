<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceGroup\InvoiceGroupStoreRequest;
use App\Http\Requests\InvoiceGroup\InvoiceGroupUpdateRequest;
use App\Invoice;
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
            ->withTrashed()
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

    /**
     * Remove the specified resource from storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function delete(Request $request, $id)
    {
        parent::delete($request, $id);
        return back();
    }

    /**
     * Destroy a record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function forceDelete(Request $request, $id)
    {
        $this->authorize('forceDelete', $this->repository);

        $group = parent::forceDelete($request, $id);

        // Move assigned invoices to another group
        if (is_numeric($request->related_invoices)) {
            Invoice::where('invoice_group_id', $id)
                ->update(['invoice_group_id' => $request->related_invoices]);
        }

        // Force delete all the invoices
        if ($request->related_invoices == 'delete') {
            $group->invoices()->forceDelete();
        }

        return redirect()->route('invoice-groups.index');
    }
}
