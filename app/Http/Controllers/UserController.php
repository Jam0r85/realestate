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
        if (!$request->all()) {
            $request->request->add(['archived' => false]);
        }
        
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
     * @param  \App\Http\Requests\UserStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $user = $this->repository
            ->fill($request->all());

        // Set the password when found in the request
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('users.show', $user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->repository
            ->findOrFail($id)
            ->fill($request->input())
            ->save();

        return back();
    }
}