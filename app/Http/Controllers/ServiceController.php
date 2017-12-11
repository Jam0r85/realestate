<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends BaseController
{
    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    public $model = 'App\Service';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = $this->repository
            ->get();

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
        $service = $this->repository;
        $service->name = $request->name;
        $service->description = $request->description;
        $service->letting_fee = $request->letting_fee;
        $service->re_letting_fee = $request->re_letting_fee;
        $service->charge = $this->formatCharge($request->charge, $request->charge_type);
        $service->tax_rate_id = $request->tax_rate_id;
        $service->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = $this->repository
            ->findOrFail($id);

        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $id
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $service = $this->repository
            ->findOrFail($id);

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
