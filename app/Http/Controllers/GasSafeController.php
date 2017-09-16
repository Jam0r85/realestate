<?php

namespace App\Http\Controllers;

use App\GasSafeReminder;
use App\Services\GasSafeService;
use Illuminate\Http\Request;

class GasSafeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reminders = GasSafeReminder::expireDate()->paginate();
        $title = 'Gas Safe Reminders';

        return view('gas-safe.index', compact('reminders','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gas-safe.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service = new GasSafeService();
        $service->createGasSafeReminder($request->input());

        $this->successMessage('The gas safe reminder was created');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GasSafe  $gasSafe
     * @return \Illuminate\Http\Response
     */
    public function show(GasSafe $gasSafe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GasSafe  $gasSafe
     * @return \Illuminate\Http\Response
     */
    public function edit(GasSafe $gasSafe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GasSafe  $gasSafe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GasSafe $gasSafe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GasSafe  $gasSafe
     * @return \Illuminate\Http\Response
     */
    public function destroy(GasSafe $gasSafe)
    {
        //
    }
}
