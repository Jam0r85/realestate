<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
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
    public function show($id)
    {
        $property = $this->properties->find($id);
        return view('properties.show', compact('property'));
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
    public function update(Request $request, Property $property)
    {
        //
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
     * Get the properties in a select2 format for a select drop down.
     * 
     * @return [type] [description]
     */
    public function select2(Request $request)
    {
        $list = $this->properties->getAll();

        foreach ($list as $item) {
            $properties[] = [
                'id' => $item->id,
                'text' => $item->name
            ];
        }

        return json_encode($properties);
    }
}
