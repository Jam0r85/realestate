<?php

namespace App\Http\Controllers;

use App\Http\Requests\Calendar\CalendarStoreRequest;
use App\Http\Requests\Calendar\CalendarUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CalendarController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calendars = $this->repository
            ->paginate();

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
     * @param  \App\Http\Requests\Calendar\CalendarStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CalendarStoreRequest $request)
    {
        $this->repository
            ->fill($request->all())
            ->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $show
     * @return \Illuminate\Http\Response
     */
    public function show($id, $section = 'show')
    {
        $calendar = $this->repository
            ->findOrFail($id);

        return view('calendars.' . $section, compact('calendar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Calendar\CalendarUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CalendarUpdateRequest $request, $id)
    {
        $this->repository
            ->findOrFail($id)
            ->fill($request->input())
            ->save();

        return back();
    }
}