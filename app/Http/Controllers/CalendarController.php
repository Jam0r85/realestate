<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCalendarRequest;
use App\Http\Requests\UpdateCalendarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CalendarController extends BaseController
{
    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    public $model = 'App\Calendar';

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
     * @param  \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(StoreCalendarRequest $request)
    {
        $calendar = $this->repository;
        $calendar->user_id = Auth::user()->id;
        $calendar->name = $request->name;
        $calendar->branch_id = $request->branch_id;
        $calendar->is_private = $request->is_private;
        $calendar->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Calendar  $calendar
     * @return  \Illuminate\Http\Response
     */
    public function show($id, $section = 'show')
    {
        $calendar = $this->repository
            ->findOrFail($id);

        return view('calendars.' . $section, compact('calendar'));
    }

    /**
     * Display the calendar and events in an iCal format for mobile devices.
     * 
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function iCalFeed($id)
    {
        $calendar = $this->repository
            ->findOrFail($id);

        // Build the calendar
        $vCalendar = new \Eluceo\iCal\Component\Calendar(config('app.url'));

        // Loop through the events and build a vEvent and add it to the vCalendar
        foreach ($calendar->events as $event) {
            $vEvent = new \Eluceo\iCal\Component\Event();
            $vEvent
                ->setUniqueId($event->id)
                ->setDtStart($event->start)
                ->setDtEnd($event->end)
                ->setSummary($event->title)
                ->setDescription($event->body);

            $vCalendar->addComponent($vEvent);
        }

        $iCal = $vCalendar->render();

        return Response::make($vCalendar->render(), '200')
            ->header('Content-type', 'text/calendar; charset=utf-8')
            ->header('Content-disposition', 'attachment; filename="cal.ics"');
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
        $this->repository
            ->findOrFail($id)
            ->fill($request->input())
            ->save();

        return back();
    }
}