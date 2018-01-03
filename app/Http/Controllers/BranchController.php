<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchStoreRequest;
use App\Http\Requests\BranchUpdateRequest;
use Illuminate\Http\Request;

class BranchController extends BaseController
{
    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    public $model = 'App\Branch';
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = $this->repository
            ->orderBy('name')
            ->get();

        return view('branches.index', compact('branches'));
    }

    /**
     * Display the form for creating a new resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('branches.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\BranchStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchStoreRequest $request)
    {
        $this->repository
            ->fill($request->input())
            ->save();

        return back();
    }

    /**
     * Display the specified resource.
     * 
     * @param  integer  $id
     * @param  string  $show
     * @return \Illuminate\Http\Response
     */
    public function show($id, $show = 'index')
    {
        $branch = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('branches.show', compact('branch','show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branch = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('branches.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request\BranchUpdateRequest  $request
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BranchUpdateRequest $request, $id)
    {
        $this->repository
            ->withTrashed()
            ->findOrFail($id)
            ->fill($request->input())
            ->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        parent::destroy($request, $id);
        return back();
    }
}
