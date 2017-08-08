<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Repositories\EloquentPropertiesRepository;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * @var  App\Repositories\EloquentPropertiesRepository
     */
    protected $properties;

    /**
     * Create a new controller instance.
     * 
     * @param   EloquentPropertiesRepository $properties
     * @return  void
     */
    public function __construct(EloquentPropertiesRepository $properties)
    {
        $this->middleware('auth');
        $this->properties = $properties;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = $this->properties->getAllPaged();
        $title = 'Properties List';

        return view('properties.index', compact('properties','title'));
    }

    /**
     * Search through the properties and display the results.
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $properties = $this->properties->search($request->search_term);
        $title = 'Search Results';

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
     * @param  \App\Http\Requests\StorePropertyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePropertyRequest $request)
    {
        $property = $this->properties->createProperty($request->input());
        return redirect()->route('properties.show', $property->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show($id, $section = 'layout')
    {
        $property = $this->properties->find($id);
        return view('properties.show.' . $section, compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePropertyRequest $request, $id)
    {
        $this->properties->update($request->input(), $id);
        return back();
    }

    /**
     * Update the properties bank account in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Property  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatementSettings(Request $request, $id)
    {
        $this->properties->updateStatementSettings($request->input(), $id);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        //
    }

    /**
     * Update the owners of the property.
     * 
     * @param Request $request
     * @param integer $id
     * @return void
     */
    public function updateOwners(Request $request, $id)
    {
        $this->properties->updateOwners($request->input(), $id);
        return back();
    }
}
