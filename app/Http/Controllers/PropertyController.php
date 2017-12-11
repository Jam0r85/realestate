<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyStoreRequest;
use App\Http\Requests\PropertyUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PropertyController extends BaseController
{
    public $model = 'App\Property';

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $properties = $this->repository
            ->with('owners')
            ->withTrashed()
            ->filter($request->all())
            ->latest()
            ->paginateFilter();

        $title = 'Properties List';
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
     * @return  \Illuminate\Http\Response
     */
    public function store(PropertyStoreRequest $request)
    {
        $property = $this->repository;
        $property->fill($request->input());
        $property->save();

        $property->settings()->storeDefault();

        if ($request->has('owners')) {
            $property->owners()->attach($request->owners);
        }

        return redirect()->route('properties.show', $property->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $section = 'layout')
    {
        $property = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('properties.show.' . $section, compact('property'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PropertyUpdateRequest  $request
     * @param  \App\Property  $id
     * @return  \Illuminate\Http\Response
     */
    public function update(PropertyUpdateRequest $request, $id)
    {
        $property = $this->repository
            ->findOrFail($id)
            ->fill($request->input())
            ->setData($request->input())
            ->save();

        $property->owners()->sync($request->owners);

        return back();
    }
}