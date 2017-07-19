<?php

namespace App\Http\Controllers;

use App\Event;
use App\Repositories\EloquentCalendarsRepository;
use App\Repositories\EloquentEventsRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * @var  App\Repositories\EloquentCalendarsRepository
     * @var  App\Repositories\EloquentEventsRepository
     */
    protected $calendars;
    protected $events;

    /**
     * Create a new controller instance.
     * 
     * @param   EloquentCalendarsRepository $calendars
     * @param   EloquentCalendarsRepository $events
     * @return  void
     */
    public function __construct(EloquentCalendarsRepository $calendars, EloquentEventsRepository $events)
    {
        $this->calendars = $calendars;
        $this->events = $events;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = $this->events->getAllPaged();
        return view('events.index', compact('events'));
    }

    /**
     * Display a listing of archived resources.
     * 
     * @param  [type] $calendar_id [description]
     * @return \Illuminate\Http\Responce
     */
    public function archived($calendar_id = null)
    {
        $events = $this->events->getArchivedPaged();
        if ($calendar_id) {
            $calendar = $this->calendars->find($calendar_id);
            return view('calendars.archived-events', compact('events','calendar'));
        }
    }

    /**
     * Return a JSON feed of events for the calendar.
     *
     * @param  $calendar_id  calendar_id 
     * @return [type] [description]
     */
    public function feed($id = null)
    {
        return $this->events->feed($id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  $id  calendar_id
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $calendar_id = $request->calendar_id;

        return view('events.create', compact('start','end','calendar_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $this->events->createEvent($data);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id = null)
    {
        $event = $this->events->find($request->event_id);
        if ($id) {
            $event = $this->events->find($id);
        }

        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token','_method');
        $this->events->updateEvent($data, $id);

        return back();
    }

    /**
     * Restore an archived event.
     * 
     * @param  integer $id [description]
     * @return [type]     [description]
     */
    public function restore($id)
    {
        $this->events->restore($id);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->events->archive($id);
        return back();
    }
}
