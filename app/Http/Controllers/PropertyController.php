<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyUpdateRequest;
use App\Http\Requests\StorePropertyRequest;
use App\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PropertyController extends BaseController
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
        $properties = Property::withTrashed()->with('owners')->latest()->paginate();
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
        $properties = Property::search($request->search_term)->get();
        $properties->load('owners');
        
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
        $service = new PropertyService();
        $property = $service->createProperty($request->input());

        $this->successMessage('The property was created');

        Cache::tags('properties')->flush();

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
        $property = Property::withTrashed()->findOrFail($id);
        return view('properties.show.' . $section, compact('property'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\PropertyUpdateRequest $request
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(PropertyUpdateRequest $request, $id)
    {
        $property = Property::findOrFail($id);
        $property->fill($request->input());
        $property->save();

        $property->owners()->sync($request->owners);

        $this->successMessage('The property ' . $property->present()->shortName . ' was updated');
        return back();
    }

    /**
     * Update the properties bank account in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatementSettings(Request $request, $id)
    {
        $service = new PropertyService();
        $service->updateStatementSettings($request->only('bank_account_id','sending_method'), $id);

        $this->successMessage('Statement settings updated');

        Cache::tags('properties')->flush();

        return back();
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
        $service = new PropertyService();
        $service->updateOwners($request->input(), $id);

        $this->successMessage('The owners were updated');

        return back();
    }

    /**
     * Archive a property.
     * 
     * @param \Illuminate\Http\Request $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function archive(Request $request, $id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        Cache::tags('properties')->flush();

        $this->successMessage('The property was archived');

        return back();
    }

    /**
     * Restore a property.
     * 
     * @param \Illuminate\Http\Request $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $property = Property::onlyTrashed()->findOrFail($id);
        $property->restore();

        Cache::tags('properties')->flush();

        $this->successMessage('The property was restored');

        return back();
    }
}
