<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyStoreRequest;
use App\Http\Requests\PropertyUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PropertyController extends BaseController
{
    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    public $model = 'App\Property';

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $properties = $this->repository
            ->with('owners')
            ->withTrashed()
            ->filter($request->all())
            ->latest()
            ->paginateFilter();

        return view('properties.index', compact('properties','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('properties.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PropertyStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PropertyStoreRequest $request)
    {
        $property = $this->repository
            ->fill($request->input())
            ->save();

        if ($request->has('owners')) {
            $property->owners()->attach($request->owners);
        }

        return redirect()->route('properties.show', $property->id);
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
        $property = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('properties.show', compact('property','show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $property = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PropertyUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PropertyUpdateRequest $request, $id)
    {
        $property = $this->repository
            ->findOrFail($id);

        $property
            ->fill($request->input())
            ->save();

        if ($request->has('owners')) {
            $property
                ->owners()
                ->sync($request->owners);
        }

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