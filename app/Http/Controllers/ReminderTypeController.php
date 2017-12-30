<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderTypeController extends BaseController
{
    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    public $model = 'App\ReminderType';

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
        $data = $request->input();
        $data['slug'] = str_slug($data['name']);
        $data['user_id'] = Auth::user()->id;

        $this->repository
            ->fill($data)
            ->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReminderType  $reminderType
     * @return \Illuminate\Http\Response
     */
    public function show(ReminderType $reminderType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReminderType  $reminderType
     * @return \Illuminate\Http\Response
     */
    public function edit(ReminderType $reminderType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReminderType  $reminderType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReminderType $reminderType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReminderType  $reminderType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        parent::destroy($request, $id);
    }
}
