<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventDestroyRequest;
use App\Http\Requests\EventForceDestroyRequest;
use App\Http\Requests\RestoreEventRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EventController extends BaseController
{
    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    public $model = 'App\Event';

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $events = $this->repository
            ->with('owner','calendar')
            ->withTrashed()
            ->filter($request->all())
            ->latest()
            ->paginateFilter();

        $title = 'Events List';
        return view('events.index', compact('events','title'));
    }

    /**
     * Get an array of events.
     *
     * @param integer $id
     * @return array
     */
    public function feed($id)
    {
        $events = $this->repository
            ->select('id', 'calendar_id', 'title', 'start', 'end', 'allDay')
            ->where('calendar_id', $id)
            ->get();

        $events = $events->toArray();

        return $events;
    }

    /**
     * Show the modal form for creating a new event.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $calendar_id = $request->calendar_id;

        return view('events.modals.new-event', compact('start', 'end', 'calendar_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = $this->repository;
        $event->user_id = Auth::user()->id;
        $event->calendar_id = $request->calendar_id;
        $event->title = $request->title;
        $event->body = $request->body;
        $event->start = Carbon::parse($request->start);
        $event->end = Carbon::parse($request->end);
        $event->save();

        $data['alert'] = [
            'class' => 'alert-success',
            'message' => 'The event "' . $event->title . '" was created'
        ];

        return $data;
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
     * Show the modal form for editing an event.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function editByModal(Request $request)
    {
        $event = $this->repository
            ->withTrashed()
            ->findOrFail($request->event_id);

        return view('events.modals.edit-event', compact('event'));
    }

    /**
     * Show the edit page for editing an event.
     *
     * @param  integer  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $event = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        $event->title = $request->title;
        $event->body = $request->body;
        $event->start = Carbon::parse($request->start);
        $event->end = Carbon::parse($request->end);
        $event->allDay = $request->has('all_day') ? '1' : '0';
        $event->save();

        if ($request->has('from_modal')) {
            $data['alert'] = [
                'class' => 'alert-success',
                'message' => 'The event "' . $event->title . '" was updated'
            ];

            return $data;
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $event = parent::destroy($request, $id);

        if ($request->has('from_modal')) {
            $data['alert'] = [
                'class' => 'alert-success',
                'message' => 'The event "' . $event->title . '" was updated'
            ];

            return $data;
        }

        return back();
    }
}