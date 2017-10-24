<?php

namespace App\Http\Controllers;

use App\Gas;
use App\Http\Requests\GasDestroyRequest;
use App\Http\Requests\StoreGasSafeReminderRequest;
use App\Mail\GasInspectionReminderEmail;
use App\Reminder;
use App\Services\GasService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

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
        $records = Gas::with('contractors','property','reminders')
            ->orderByExpireDate()
            ->paginate();

        $title = 'Gas Safe Reminders';

        return view('gas-safe.index', compact('records','title'));
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
        $gas = Gas::withTrashed()->findOrFail($id);
        return view('gas-safe.show.' . $section, compact('gas'));
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
    public function destroy(GasDestroyRequest $request, $id)
    {
        $gas = Gas::findOrFail($id);

        $gas->forceDelete();

        $this->successMessage('The gas inspection for "' . $gas->property->short_name . '" was deleted');

        return redirect()->route('gas-safe.index');
    }

    /**
     * Complete a gas inspection.
     * 
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function complete(Request $request, $id)
    {
        $gas = Gas::findOrFail($id);

        if ($request->expires_on) {
            $new = $gas->replicate();
            $new->expires_on = $request->expires_on;
            $new->push();

            foreach ($gas->contractors as $contractor) {
                $new->contractors()->attach($contractor);
            }
        }

        $gas->is_completed = true;
        $gas->save();
        $gas->delete();

        $this->successMessage('The gas inspection has been marked as completed');

        return back();
    }

    /**
     * Send a reminder for this gas inspection.
     * 
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function sendReminder(Request $request, $id)
    {
        $gas = Gas::findOrFail($id);
        $contractor_ids = $gas->contractors->pluck('id')->toArray();
        $owner_ids = $gas->property->owners->pluck('id')->toArray();

        // Set the default 1st reminder messages.
        $contractor_default_body = '<p>Please can you arrange to carry out the annual landlords Gas Safe inspection at ' . $gas->property->name . '</p>';
        $owner_default_body = '<p>Please can you arrange to have your contractor carry out the annual Gas Safe inspection at ' . $gas->property->name .'</p>';

        // Overwrite the message if a body is present.
        if ($request->body) {
            $reminder_body = '<p>' . $request->body . '</p>';
        }

        // Get the tenant details if we tick the box.
        if ($request->has('tenants')) {
            $tenants_body = '';
            foreach ($request->tenants as $tenant) {
                $user = User::findOrFail($tenant);
                $tenants_body .= '<p><b>' . $user->name . '</b></p>';
                $tenants_body .= '<ul>';
                $user->email ?  $tenants_body .= '<li>' . $user->email . '</li>' : '';
                $user->phone_number ?  $tenants_body .= '<li>' . $user->phone_number . '</li>' : '';
                $tenants_body .= '</ul>';
            }
        }

        // Loop through the recipients
        foreach ($request->recipients as $recipient) {

            // Contractor message
            if (in_array($recipient, $contractor_ids)) {
                if (!$request->body) {
                    $reminder_body = $contractor_default_body;
                    $reminder_body .= '<p>The tenants details are as follows:-</p>';
                    $reminder_body .= isset($tenants_body) ? $tenants_body : '';
                }
            }

            // Owner message
            if (in_array($recipient, $owner_ids)) {
                if (!$request->body) {
                    $reminder_body = $owner_default_body;
                }
            }

            if ($request->has('tenants') && $request->body) {
                $reminder_body .= $tenants_body;
            }

            $reminder = new Reminder();
            $reminder->body = $reminder_body;
            $reminder->user_id = Auth::user()->id;
            $reminder->recipient_id = $recipient;

            $gas->reminders()->save($reminder);

            Mail::to($reminder->recipient)
                ->send(new GasInspectionReminderEmail($gas, $reminder_body));
        }

        $this->successMessage('The ' . str_plural('reminder', count($request->recipients)) . ' was sent');

        return back();
    }
}
