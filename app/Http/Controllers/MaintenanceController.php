<?php

namespace App\Http\Controllers;

use App\Tenancy;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class MaintenanceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('list', $this->repository);

        $issues = $this->repository
            ->latest()
            ->filter($request->all())
            ->paginateFilter();

        return view('maintenances.index', compact('issues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', $this->repository);

        $latest_issues = $this->repository
            ->latest()
            ->limit(10)
            ->get();

        return view('maintenances.create', compact('latest_issues'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', $this->repository);

        $data = $request->input();
        
        $data['property_id'] = $data['property_id'] ?? Tenancy::findOrFail($data['tenancy_id'])->property_id;

        $this->repository
            ->fill($data)
            ->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $show
     * @return \Illuminate\Http\Response
     */
    public function show($id, $show = 'index')
    {
        $issue = $this->repository
            ->findOrFail($id);

        $this->authorize('view', $issue);

        return view('maintenances.show', compact('issue','show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $issue = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('maintenances.edit', compact('issue'));
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
        $issue = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        $this->authorize('update', $issue);

        $issue
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
    public function delete(Request $request, $id)
    {
        parent::delete($request, $id);
        return back();
    }
}
