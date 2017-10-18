<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\DestroyEventRequest;
use App\Http\Requests\RestoreEventRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EventController extends BaseController
{
    /**
     * Create a new controller instance.
     *
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
        $events = Event::withTrashed()->with('owner','calendar')->latest()->paginate();
        $title = 'Events List';

        return view('events.index', compact('events','title'));
    }

    /**
     * Search the events.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Clear the search term.
        if ($request && $request->has('clear_search')) {
            Session::forget('events_search_term');
            return redirect()->route('events.index');
        }

        Session::put('events_search_term', $request->search_term);

        $events = Event::search(Session::get('events_search_term'))->get();
        $title = 'Search Results';

        return view('events.index', compact('events', 'title'));
    }

    /**
     * Get an array of archived events.
     *
     * @param integer $id
     * @return array
     */
    public function archivedFeed($id)
    {
        $events = Event::select('id', 'calendar_id', 'title', 'start', 'end', 'all_day')
            ->onlyTrashed()
            ->where('calendar_id', $id)
            ->get()
            ->toArray();

        return $json;
    }

    /**
     * Get an array of events.
     *
     * @param integer $id
     * @return array
     */
    public function feed($id)
    {
        $events = Event::select('id', 'calendar_id', 'title', 'start', 'end', 'allDay')
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
        $event = new Event();
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
        $event = Event::withTrashed()->findOrFail($request->event_id);
        return view('events.modals.edit-event', compact('event'));
    }

    /**
     * Show the edit page for editing an event.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::withTrashed()->findOrFail($id);
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $event = Event::withTrashed()->findOrFail($id);

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

        $this->successMessage('The event "' . $event->title . '" was updated');

        return back();
    }

    /**
     * Restore an event.
     *
     * @param \App\Http\Requests\RestoreEventRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function restore(RestoreEventRequest $request, $id)
    {
        $event = Event::onlyTrashed()->findOrFail($id);
        $event->restore();

        $this->successMessage('The event "' . $event->title . '" was restored');

        return back();
    }

    /**
     * Delete an event.
     *
     * @param \App\Http\Requests\DestroyEventRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyEventRequest $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        if ($request->has('from_modal')) {
            $data['alert'] = [
                'class' => 'alert-success',
                'message' => 'The event "' . $event->title . '" was deleted'
            ];

            return $data;
        }

        $this->successMessage('The event "' . $event->title . '" was deleted');

        return back();
    }
}
