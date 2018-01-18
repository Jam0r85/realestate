<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermissionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('list', $this->repository);

        $permissions = $this->repository->orderBy('slug')->get();

        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', $this->repository);

        $latestPermissions = $this->repository->limit(15)->get();

        return view('permissions.create', compact('latestPermissions'));
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

        if (!$data['slug']) {
            $data['slug'] = $data['name'];
        }

        $this->repository
            ->fill($data)
            ->save();

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = $this->repository
            ->findOrFail($id);

        $this->authorize('update', $permission);

        return view('permissions.edit', compact('permission'));
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
        $permission = $this->repository
            ->findOrFail($id);

        $this->authorize('update', $permission);

        $permission
            ->fill($request->input())
            ->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
    }
}
