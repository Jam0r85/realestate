<?php

namespace App\Http\Controllers;

use App\Valuation;
use Illuminate\Http\Request;

class ValuationController extends BaseController
{
    /**
     * The eloquent modal for this controller.
     * 
     * @return string
     */
    protected $model = 'App\Valuation';

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Valuation  $valuation
     * @return \Illuminate\Http\Response
     */
    public function show(Valuation $valuation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Valuation  $valuation
     * @return \Illuminate\Http\Response
     */
    public function edit(Valuation $valuation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Valuation  $valuation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Valuation $valuation)
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
