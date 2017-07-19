<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserEmailRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserPhoneRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\SendUserEmail;
use App\Repositories\EloquentUsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends BaseController
{
    /**
     * @var  App\Repositories\EloquentUsersRepository
     */
    protected $users;

    /**
     * Create a new controller instance.
     * 
     * @param   EloquentUsersRepository $users
     * @return  void
     */
    public function __construct(EloquentUsersRepository $users)
    {
        $this->middleware('auth');
        $this->users = $users;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->users->getAllPaged();
        $title = 'Users List';
        return view('users.index', compact('users','title'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function archived()
    {
        $users = $this->users->getArchivedPaged();
        $title = 'Archived Users';
        return view('users.index', compact('users','title'));
    }

    /**
     * Search through the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $users = $this->users->search($request->search_term);
        $search_term = $request->search_term;
        return view('users.index', compact('users','search_term'));
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
        $user = $this->users->createUser($request->input());        
        return view('users.show', compact('user'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @param  string     $section
     * @return \Illuminate\Http\Response
     */
    public function show($id, $section = null)
    {
        $user = $this->users->find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing a resource.
     * 
     * @param  integer $id
     * @return \Illuminate\Http\Responce
     */
    public function edit($id)
    {
        $user = $this->users->find($id);
        return view('users.edit', compact('user'));
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
        $data = $request->except('_token');
        $user = $this->users->updateUser($data, $id);

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
        $user = $this->users->updateEmail($request->email, $id);
        return back();
    }

    /**
     * Update the user's email address in storage.
     *
     * @param  \App\Http\Requests\UpdateUserEmailRequest  $request
     * @param  \App\User  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePhone(UpdateUserPhoneRequest $request, $id)
    {
        $data = $request->only('phone_number','phone_number_other');
        $user = $this->users->updatePhone($data, $id);
        
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
        $user = $this->users->updatePassword($request->password, $id);
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
     * Send the user an email message.
     * 
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User                $id
     * @return \Illuminate\Http\Response
     */
    public function sendEmail(Request $request, $id)
    {
        $user = $this->users->find($id);
        Mail::to($user)->send(new SendUserEmail($request->subject, $request->body, $request->attachments));
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
        $user = $this->users->archive($id);
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
        $user = $this->users->restore($id);
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
