<?php

namespace App\Http\Controllers;

use App\Repositories\EloquentTenanciesRepository;
use Illuminate\Http\Request;

class TenancyController extends Controller
{
    /**
     * @var  App\Repositories\EloquentTenanciesRepository
     */
    protected $tenancies;

    /**
     * Create a new controller instance.
     * 
     * @param   EloquentTenanciesRepository $properties
     * @return  void
     */
    public function __construct(EloquentTenanciesRepository $tenancies)
    {
        $this->middleware('auth');
        $this->tenancies = $tenancies;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenancies = $this->tenancies->getAllPaged();
        $title = 'Tenancies List';

        return view('tenancies.index', compact('tenancies','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tenancy  $tenancy
     * @return \Illuminate\Http\Response
     */
    public function show(Tenancy $tenancy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tenancy  $tenancy
     * @return \Illuminate\Http\Response
     */
    public function edit(Tenancy $tenancy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tenancy  $tenancy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tenancy $tenancy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tenancy  $tenancy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tenancy $tenancy)
    {
        //
    }
}
