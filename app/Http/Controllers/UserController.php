<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendUserEmailRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserEmailRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserPhoneRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\SendUserEmail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserController extends BaseController
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
        $users = User::with('properties')->latest()->paginate();
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
        $users = User::with('properties')->onlyTrashed()->latest()->paginate();
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
        $users = User::with('properties')->search($request->search_term)->get();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->input());
        $this->successMessage('The user was created');

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
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\User  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->fill($request->input());
        $user->save();

        $this->successMessage('The user was updated');

        Cache::tags('users')->flush();

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
        $user->email = $request->email;
        $user->save();

        $this->successMessage('The users email was updated');

        return back();
    }

    /**
     * Update the user's password in storage.
     *
     * @param  \App\Http\Requests\UpdateUserPasswordRequest  $request
     * @param  \App\User  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(UpdateUserPasswordRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->password = bcrypt($request->password);
        $user->save();

        $this->successMessage('The users password was updated');

        return back();
    }

    /**
     * Update the user's password in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $id
     * @return \Illuminate\Http\Response
     */
    public function updateGroups(Request $request, $id)
    {
        $user = $this->users->syncUserGroups($request->group_id, $id);
        return back();
    }

    /**
     * Update the user's roles in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRoles(Request $request, $id)
    {
        $user = $this->users->syncUserRoles($request->role_id, $id);
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

        $this->successMessage('The users home address was updated');

        return back();
    }

    /**
     * Send the user an email message.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User                $id
     * @return \Illuminate\Http\Response
     */
    public function sendEmail(SendUserEmailRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if (!$user->email) {
            return back();
        }

        Mail::to($user)->send(
            new SendUserEmail($request->subject, $request->message, $request->attachments)
        );

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
}
