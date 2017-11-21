<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserEmailRequest;
use App\Http\Requests\UpdateUserPhoneRequest;
use App\Http\Requests\{UserStoreRequest, UserUpdateRequest, UserSendEmailRequest};
use App\Notifications\UserEmail;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserController extends BaseController
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
        $users = User::with('home','tenancies','tenancies.property')->latest()->paginate();
        $title = 'Users List';
        
        return view('users.index', compact('users', 'title'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function archived()
    {
        $users = User::onlyTrashed()->latest()->paginate();
        $title = 'Archived Users';

        return view('users.index', compact('users', 'title'));
    }

    /**
     * Search through the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Clear the search term.
        if ($request && $request->has('clear_search')) {
            Session::forget('users_search_term');
            return redirect()->route('users.index');
        }

        Session::put('users_search_term', $request->search_term);

        $users = User::search(Session::get('users_search_term'))->get();
        $title = 'Search Results';

        return view('users.index', compact('users', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\UserStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $user = new User();
        $user->title = $request->title;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->company_name = $request->company_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->phone_number_other = $request->phone_number_other;
        $user->password = bcrypt($request->password ?? str_random(10));
        $user->save();

        $user->settings()->storeDefault();

        $this->successMessage('The user "' . $user->name . '" was created');

        Cache::tags('users')->flush();

        return redirect()->route('users.show', $user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @param  string     $section
     * @return \Illuminate\Http\Response
     */
    public function show($id, $section = 'layout')
    {
        $user = User::withTrashed()->findOrFail($id);
        return view('users.show.' . $section, compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UserUpdateRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->title = $request->title;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->company_name = $request->company_name;
        $user->phone_number = $request->phone_number;
        $user->phone_number_other = $request->phone_number_other;
        $user->save();

        $this->successMessage('The user "' . $user->name . '" was updated');

        Cache::tags('users')->flush();

        return back();
    }

    /**
     * Update the user's settings.
     * 
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function updateSettings(Request $request, $id)
    {
        // Dark Mode Toggle
        if (!$request->has('dark_mode')) {
            $request->request->add(['dark_mode' => null]);
        }

        // Notification Toggles
        if (!$request->has('expense_record_notifications_sms')) {
            $request->request->add(['expense_record_notifications_sms' => null]);
        }

        if (!$request->has('expense_record_notifications_email')) {
            $request->request->add(['expense_record_notifications_email' => null]);
        }

        if (!$request->has('rent_payment_received_notification_email')) {
            $request->request->add(['rent_payment_received_notification_email' => null]);
        }

        if (!$request->has('rent_payment_received_notification_sms')) {
            $request->request->add(['rent_payment_received_notification_sms' => null]);
        }

        $user = User::findOrFail($id);
        $user->settings()->merge($request->input());

        $this->successMessage('The users settings were updated');

        return back();
    }

    /**
     * Update the user's email address in storage.
     *
     * @param  \App\Http\Requests\UpdateUserEmailRequest  $request
     * @param  \App\User  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEmail(UpdateUserEmailRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->email && $request->has('remove_email')) {
            $service = new UserService();
            $service->removeUserEmail($user);

            $this->successMessage('The e-mail for this user was removed');

            return back();
        }

        $user->email = $request->email;
        $user->save();

        $this->successMessage('The users e-mail was updated');

        return back();
    }

    /**
     * Update the user's home address in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $id
     * @return \Illuminate\Http\Response
     */
    public function updateHomeAddress(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->property_id = $request->property_id;
        $user->save();

        $this->successMessage('The users location was updated');

        return back();
    }

    /**
     * Send the user an email message.
     *
     * @param \App\Http\Requests\UserSendEmailRequest $request
     * @param  \App\User                $id
     * @return \Illuminate\Http\Response
     */
    public function sendEmail(UserSendEmailRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->notify(new UserEmail($request->subject, $request->message));

        $this->successMessage('The email was sent to the user');      
        return back();
    }

    /**
     * Archive the specified resource in storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Responce
     */
    public function archive($id)
    {
        User::findOrFail($id);
        $user->deleted_at = Carbon::now();
        $user->save();

        $this->successMessage('The user was archived');

        return back();
    }

    /**
     * Restore the specified resource in storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Responce
     */
    public function restore($id)
    {
        $user = User::findOrFail($id);
        $user->deleted_at = null;
        $user->save();

        $this->successMessage('The user was restored');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * Mark all unread notifications as having been read.
     * 
     * @param  \App\User  $user
     * @return  \Illuminate\Http\Response
     */
    public function clearNotifications(User $user)
    {
        $user->unreadNotifications->markAsRead();

        $this->successMessage('All notifications have been marked as read');
        return back();
    }
}
