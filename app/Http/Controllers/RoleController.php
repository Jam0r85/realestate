<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBranchRoleRequest;
use App\Repositories\EloquentRolesRepository;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    /**
     * @var  App\Repositories\EloquentRolesRepository
     */
    protected $roles;

    /**
     * Create a new controller instance.
     * 
     * @param   EloquentRolesRepository $users
     * @return  void
     */
    public function __construct(EloquentRolesRepository $roles)
    {
        $this->middleware('auth');
        $this->roles = $roles;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->roles->getAllPaged();
        return view('settings.roles', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBranchRoleRequest $request)
    {
        $data = $request->except('_token');
        $this->roles->createRole($data);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BranchRole  $branchRole
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $branch = $this->branches->find($id);
        return view('branches.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BranchRole  $branchRole
     * @return \Illuminate\Http\Response
     */
    public function edit(BranchRole $branchRole)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BranchRole  $branchRole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BranchRole $branchRole)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BranchRole  $branchRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(BranchRole $branchRole)
    {
        //
    }
}
