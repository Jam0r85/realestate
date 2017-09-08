<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use Illuminate\Http\Request;

class BranchController extends BaseController
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
        $branches = Branch::get();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBranchRequest $request)
    {
        $branch = new Branch();
        $branch->fill($request->input());
        $branch->save();

        $this->successMessage('The branch was created');

        return back();
    }

    /**
     * Display the specified resource.
     * 
     * @param integer $id
     * @param string $section
     * @return \Illuminate\Http\Response
     */
    public function show($id, $section = 'layout')
    {
        $branch = Branch::findOrFail($id);
        return view('branches.show.' . $section, compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Request\UpdateBranchRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBranchRequest $request, $id)
    {
        $branch = Branch::findOrFail($id);
        $branch->fill($request->input());
        $branch->save();

        $this->successMessage('Changes were saved');

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
