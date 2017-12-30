<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserEmailRequest;
use App\Http\Requests\UpdateUserPhoneRequest;
use App\Http\Requests\{UserStoreRequest, UserUpdateRequest};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserController extends BaseController
{
    /**
     * The model for this controller.
     * 
     * @var string
     */
    public $model = 'App\User';

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = $this->repository
            ->with('home','tenancies','tenancies.property')
            ->withTrashed()
            ->filter($request->all())
            ->latest()
            ->paginateFilter();
            
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $latestUsers = $this->repository
            ->latest()
            ->limit(15)
            ->get();

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
        $user = $this->repository;
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
    public function show($id, $show = 'index')
    {
        $user = $this->repository
            ->with('properties.owners','tenancies.users','sms.user','sms.owner')
            ->withTrashed()
            ->findOrFail($id);

        return view('users.show', compact('user','show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->repository
            ->findOrFail($id)
            ->fill($request->input())
            ->save();

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
        $user = $this->repository
            ->findOrFail($id);

        if ($user->email && $request->has('remove_email')) {
            $service = new UserService();
            $service->removeUserEmail($user);
            return back();
        }

        $user->email = $request->email;
        $user->save();

        return back();
    }
}
