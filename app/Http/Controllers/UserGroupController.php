<?php

namespace App\Http\Controllers;

use App\Repositories\EloquentUserGroupsRepository;
use App\Http\Requests\StoreUserGroupRequest;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    /**
     * @var  App\Repositories\EloquentUserGroupsRepository
     */
    protected $user_groups;

    /**
     * Create a new controller instance.
     * 
     * @param   EloquentUserGroupsRepository $users
     * @return  void
     */
    public function __construct(EloquentUserGroupsRepository $user_groups)
    {
        $this->middleware('auth');
        $this->user_groups = $user_groups;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = $this->user_groups->getAll();
        return view('user-groups.index', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserGroupRequest $request)
    {
        $data = $request->except('_token');
        $this->user_groups->createUserGroup($data);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $group = $this->user_groups->findBySlug($slug);
        return view('user-groups.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = $this->user_groups->find($id);
        return view('user-groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $this->user_groups->updateUserGroup($data, $id);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserGroup $userGroup)
    {
        //
    }
}
