<?php

namespace App\Http\Controllers;

use App\Http\Requests\TenancyRentStoreRequest;
use App\Tenancy;
use App\TenancyRent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenancyRentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function store(TenancyRentStoreRequest $request)
    {
        $tenancy = Tenancy::findOrFail($request->tenancy_id);

        $rent = new TenancyRent();
        $rent->user_id = Auth::user()->id;
        $rent->amount = $request->amount;
        $rent->starts_at = $request->starts_at;

        $tenancy->rents()->save($rent);

        $this->successMessage('The new rent amount of ' . $rent->amount . ' was stored for the tenancy ' . $tenancy->name);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TenancyRent  $tenancyRent
     * @return \Illuminate\Http\Response
     */
    public function show(TenancyRent $tenancyRent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TenancyRent  $tenancyRent
     * @return \Illuminate\Http\Response
     */
    public function edit(TenancyRent $tenancyRent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TenancyRent  $tenancyRent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TenancyRent $tenancyRent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TenancyRent  $tenancyRent
     * @return \Illuminate\Http\Response
     */
    public function destroy(TenancyRent $tenancyRent)
    {
        //
    }
}
