<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class ServiceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::get();
        return view('services.index', compact('services'));     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service = new Service();
        $service->name = $request->name;
        $service->description = $request->description;
        $service->letting_fee = $request->letting_fee;
        $service->re_letting_fee = $request->re_letting_fee;
        $service->charge = $this->formatCharge($request->charge, $request->charge_type);
        $service->tax_rate_id = $request->tax_rate_id;
        $service->save();

        $this->successMessage('The service "' . $service->name . '" was created');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->name = $request->name;
        $service->description = $request->description;
        $service->letting_fee = $request->letting_fee;
        $service->re_letting_fee = $request->re_letting_fee;
        $service->charge = $this->formatCharge($request->charge, $request->charge_type);
        $service->tax_rate_id = $request->tax_rate_id;
        $service->save();

        $this->successMessage('The service "' . $service->name . '" was updated');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        //
    }

    /**
     * Format the charge based on the amount and type.
     * 
     * @param integer $amount
     * @param string $type
     * @return integer
     */
    private function formatCharge($amount, $type)
    {
        if ($type == 'percent') {
            return $amount / 100;
        }

        return $amount;
    }
}
