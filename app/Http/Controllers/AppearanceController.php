<?php

namespace App\Http\Controllers;

use App\Appearance;
use App\Http\Requests\AppearanceStoreRequest;
use Illuminate\Http\Request;

class AppearanceController extends Controller
{
    protected $sections = [
        'Live',
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
        $live_appearances = Appearance::latest()->paginate();

        $sections = $this->sections;

        return view('appearances.index', compact('live_appearances','sections'));
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
        //
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
