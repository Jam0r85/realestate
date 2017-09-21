<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Http\Requests\StoreCalendarRequest;
use App\Http\Requests\UpdateCalendarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends BaseController
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
        $calendars = Calendar::paginate();
        return view('calendars.index', compact('calendars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('calendars.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCalendarRequest $request)
    {
        $calendar = new Calendar();
        $calendar->user_id = Auth::user()->id;
        $calendar->fill($request->input());
        $calendar->save();

        $this->successMessage('The calendar ' . $calendar->name . ' was created');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function show($id, $section = 'show')
    {
        $calendar = Calendar::findOrFail($id);
        return view('calendars.' . $section, compact('calendar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCalendarRequest $request, $id)
    {
        $data = $request->except('_token');
        $calendar = $this->calendars->update($data, $id);
        return back();
    }

    /**
     * Archive the specified resource.
     *
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $this->calendars->archive($id);
        return back();
    }

    /**
     * Restore the specified resource.
     *
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $this->calendars->restore($id);
        return back();
    }
}
