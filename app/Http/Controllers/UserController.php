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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('home','tenancies','tenancies.property')->latest();

        $sections = ['Active','Archived'];

        $active_users = $users->paginate();
        $archived_users = $users->onlyTrashed()->paginate();
        $title = 'Users List';
        
        return view('users.index', compact('active_users','archived_users','title','sections'));
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

        $searchResults = User::search(Session::get('users_search_term'))->get();
        $title = 'Search Results';

        return view('users.index', compact('searchResults', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $latestUsers = User::limit(15)->latest()->get();
        return view('users.create', compact('latestUsers'));
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

        return redirect()->route('users.show', $user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @param  string  $page
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, $page = 'layout')
    {
        $bank_accounts = $user->bankAccounts;
        $properties = $user->properties()->with('owners')->get();
        $tenancies = $user->tenancies()->with('tenants')->get();
        $invoices = $user->invoices()->with('users','property','items','items.taxRate')->paginate();
        $sms_messages = $user->sms()->with('user','owner')->get();

        return view('users.pages.' . $page, compact(
            'user',
            'bank_accounts',
            'properties',
            'tenancies',
            'invoices',
            'sms_messages'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->fill($request->input());
        $user->save();

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
