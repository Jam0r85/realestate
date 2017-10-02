<?php

namespace App\Http\Controllers;

use App\Gas;
use App\Http\Requests\StoreGasSafeReminderRequest;
use App\Services\GasService;
use Illuminate\Http\Request;

class GasController extends BaseController
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
        $reminders = Gas::expireDate()->paginate();
        $title = 'Gas Safe Reminders';

        return view('gas-safe.index', compact('reminders','title'));
    }

    /**
     * Search through the resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Clear the search term.
        if ($request && $request->has('clear_search')) {
            Session::forget('gas_search_term');
            return redirect()->route('gas-safe.index');
        }

        Session::put('gas_search_term', $request->search_term);

        $reminders = Gas::search(Session::get('gas_search_term'))->get();
        $title = 'Search Results';

        return view('gas-safe.index', compact('reminders', 'title'));
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
        $service = new GasService();
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
        $reminder = Gas::findOrFail($id);
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
        $reminder = Gas::findOrFail($id);
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
    public function destroy($id)
    {
        $reminder = Gas::findOrFail($id);
        $reminder->delete();

        $this->successMessage('The reminder was deleted');

        return redirect()->route('gas-safe.index');
    }
}
