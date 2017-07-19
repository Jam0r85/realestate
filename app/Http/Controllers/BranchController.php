<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Repositories\EloquentBranchesRepository;
use Illuminate\Http\Request;

class BranchController extends BaseController
{
    /**
     * @var  App\Repositories\EloquentBranchesRepository
     */
    protected $branches;

    /**
     * Create a new controller instance.
     * 
     * @param   EloquentBranchesRepository $users
     * @return  void
     */
    public function __construct(EloquentBranchesRepository $branches)
    {
        $this->middleware('auth');
        $this->branches = $branches;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = $this->branches->getAllPaged();
        return view('settings.branches', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBranchRequest $request)
    {
        $data = $request->except('_token');
        $this->branches->create($data);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $branch = $this->branches->find($id);
        return view('branches.show', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBranchRequest $request, $id)
    {
        $data = $request->except('_token');
        $this->branches->update($data, $id);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        //
    }
}
