<?php

namespace App\Http\Controllers;

use App\GasSafeReminder;
use App\Http\Requests\StoreGasSafeReminderRequest;
use App\Services\GasSafeService;
use Illuminate\Http\Request;

class GasSafeController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @param   EloquentUsersRepository $users
     * @return  void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
    public function store(StoreGasSafeReminderRequest $request)
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
    public function show($id, $section = 'layout')
    {
        $reminder = GasSafeReminder::findOrFail($id);
        return view('gas-safe.show.' . $section, compact('reminder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GasSafe  $gasSafe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reminder = GasSafeReminder::findOrFail($id);
        $reminder->fill($request->input());
        $reminder->save();

        $reminder->contractors()->sync($request->contractors);

        $this->successMessage('The reminder was updated');

        return back();
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
