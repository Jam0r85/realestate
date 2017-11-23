<?php

namespace App\Http\Controllers;

use App\Appearance;
use App\AppearancePrice;
use App\AppearancePriceQualifier;
use App\AppearanceSection;
use App\AppearanceStatus;
use App\Http\Requests\AppearanceStoreRequest;
use App\Property;
use Illuminate\Http\Request;

class AppearanceController extends BaseController
{
    /**
     * The individual sections to be show on the resource listing.
     * 
     * @var array
     */
    protected $sections = [
        'Live',
        'Pending',
        'Hidden',
        'Archived'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appearances = Appearance::with('section','status','property')->latest();
        $live_appearances = $appearances->get();
        $hidden_appearances = $appearances->get();
        $pending_appearances = $appearances->get();

        $sections = $this->sections;

        return view('appearances.index', compact(
            'live_appearances',
            'hidden_appearances',
            'pending_appearances',
            'sections'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('appearances.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AppearanceStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AppearanceStoreRequest $request)
    {
        $property = Property::findOrFail($request->property_id);
        $section = AppearanceSection::findOrFail($request->section_id);
        $status = AppearanceStatus::findOrFail($request->status_id);
        $qualifier = AppearancePriceQualifier::findOrFail($request->qualifier_id);

        $appearance = new Appearance();
        $appearance->live_at = $request->live_at;
        $appearance->summary = $request->summary;
        $appearance->description = $request->description;
        $appearance->live_at = $request->live_at;

        $appearance->status()->associate($status);
        $appearance->property()->associate($property);
        $appearance->section()->associate($section);

        $appearance->save();

        $price = new AppearancePrice();
        $price->amount = $request->price;
        $price->qualifier()->associate($qualifier);

        $appearance->storePrice($price);

        $this->successMessage('The new appearance was saved');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Appearance  $appearance
     * @return \Illuminate\Http\Response
     */
    public function show(Appearance $appearance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appearance  $appearance
     * @return \Illuminate\Http\Response
     */
    public function edit(Appearance $appearance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appearance  $appearance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appearance $appearance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appearance  $appearance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appearance $appearance)
    {
        //
    }
}
