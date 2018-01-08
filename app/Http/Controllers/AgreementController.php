<?php

namespace App\Http\Controllers;

use App\Tenancy;
use Illuminate\Http\Request;

class AgreementController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->all()) {
            $request->request->add(['archived' => false]);
        }
        
        $agreements = $this->repository
            ->withTrashed()
            ->filter($request->all())
            ->latest()
            ->paginateFilter();

        return view('agreements.index', compact('agreements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tenancy  $tenancy
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenancy $tenancy)
    {
        $agreement = $this->repository
            ->fill($request->input());

        $tenancy->storeAgreement($agreement);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function show(Agreement $agreement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function edit(Agreement $agreement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agreement $agreement)
    {
        //
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
        parent::destroy($request, $id);
    }
}
