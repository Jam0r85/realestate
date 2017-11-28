<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyStoreRequest;
use App\Http\Requests\PropertyUpdateRequest;
use App\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PropertyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $active_properties = Property::withTrashed()->with('owners')->latest()->paginate();

        $sections = ['Active'];
        $title = 'Properties List';

        return view('properties.index', compact('active_properties','title','sections'));
    }

    /**
     * Search through the properties and display the results.
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Clear the search term.
        if ($request && $request->has('clear_search')) {
            Session::forget('properties_search_term');
            return redirect()->route('properties.index');
        }

        Session::put('properties_search_term', $request->search_term);

        $searchResults = Property::search(Session::get('properties_search_term'))->get();
        $searchResults->load('owners');
        
        $title = 'Search Results';

        return view('properties.index', compact('searchResults','title'));
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
        $property = new Property();
        $property->fill($request->input());
        $property->save();

        $property->settings()->storeDefault();

        if ($request->has('owners')) {
            $property->owners()->attach($request->owners);
        }

        $this->successMessage('The property ' . $property->present()->shortAddress . ' was created');
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
     * @param  \App\Http\Requests\PropertyUpdateRequest  $request
     * @param  \App\Property  $property
     * @return  \Illuminate\Http\Response
     */
    public function update(PropertyUpdateRequest $request, Property $property)
    {
        $property->fill($request->input());
        $property->setData($request->input());
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

        $this->successMessage('The property was restored');

        return back();
    }
}
