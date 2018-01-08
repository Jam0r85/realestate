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
use Illuminate\Support\Carbon;

class AppearanceController extends BaseController
{
    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    public $model = 'App\Appearance';

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
        $live_appearances = Appearance::eagerLoading()->liveAndVisible()->get();
        $hidden_appearances = Appearance::eagerLoading()->hidden()->get();
        $pending_appearances = Appearance::eagerLoading()->pending()->get();
        $archived_appearances = Appearance::eagerLoading()->onlyTrashed()->paginate();

        $sections = $this->sections;

        return view('appearances.index', compact(
            'live_appearances',
            'hidden_appearances',
            'pending_appearances',
            'archived_appearances',
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

        $appearance = $this->repository
            ->fill($request->all());

        $appearance->status()->associate($status);
        $appearance->property()->associate($property);
        $appearance->section()->associate($section);

        $appearance->save();

        $price = new AppearancePrice();
        $price->amount = $request->price;
        $price->qualifier()->associate($qualifier);

        $appearance->storePrice($price);

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
}
