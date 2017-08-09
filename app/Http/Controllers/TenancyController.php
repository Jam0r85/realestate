<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatementRequest;
use App\Http\Requests\StoreTenancyRentPaymentRequest;
use App\Http\Requests\StoreTenancyRequest;
use App\Http\Requests\TenantsVacatedRequest;
use App\Repositories\EloquentStatementsRepository;
use App\Repositories\EloquentTenanciesRepository;
use Illuminate\Http\Request;

class TenancyController extends Controller
{
    /**
     * @var  App\Repositories\EloquentTenanciesRepository
     * @var  App\Repositories\EloquentStatementsRepository
     */
    protected $tenancies;
    protected $statements;

    /**
     * Create a new controller instance.
     * 
     * @param   EloquentTenanciesRepository $properties
     * @return  void
     */
    public function __construct(EloquentTenanciesRepository $tenancies, EloquentStatementsRepository $statements)
    {
        $this->middleware('auth');

        $this->tenancies = $tenancies;
        $this->statements = $statements;
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
     * Display a listing of tenancies with a rent balance.
     *
     * @return \Illuminate\Http\Response
     */
    public function overdue()
    {
        $tenancies = $this->tenancies->getOverdueList();
        $title = 'Overdue Tenancies';

        return view('tenancies.overdue', compact('tenancies','title'));
    }

    /**
     * Search through the resource and display the results.
     * 
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function search(Request $request)
    {
        $tenancies = $this->tenancies->search($request->search_term);
        $title = 'Search Results';

        return view('tenancies.index', compact('tenancies','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tenancies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTenancyRequest $request)
    {
        $tenancy = $this->tenancies->createTenancy($request->input());
        return redirect()->route('tenancies.show', $tenancy->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tenancy  $tenancy
     * @return \Illuminate\Http\Response
     */
    public function show($id, $section = 'dashboard')
    {
        $tenancy = $this->tenancies->find($id);
        return view('tenancies.show.' . $section, compact('tenancy'));
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
     * Store a new tenancy rent payment in storage.
     * 
     * @param  StoreTenancyRentPaymentRequest $request
     * @param  \App\Tenancy                   $id
     * @return \Illuminate\Http\Response
     */
    public function createRentPayment(StoreTenancyRentPaymentRequest $request, $id)
    {
        $this->tenancies->createRentPayment($request->input(), $id);
        return back();
    }

    /**
     * Store a new tenancy rent payment in storage.
     * 
     * @param  StoreTenancyRentPaymentRequest $request
     * @param  \App\Tenancy                   $id
     * @return \Illuminate\Http\Response
     */
    public function createRentalStatement(StoreStatementRequest $request, $id)
    {
        $this->statements->createStatement($request->input(), $id);
        return back();
    }

    /**
     * Store an old tenancy rental statement in storage.
     * 
     * @param  StoreTenancyRentPaymentRequest $request
     * @param  \App\Tenancy                   $id
     * @return \Illuminate\Http\Response
     */
    public function createOldRentalStatement(StoreStatementRequest $request, $id)
    {
        $this->statements->createOldStatement($request->input(), $id);
        return back();
    }

    /**
     * Update the discounts for a tenancy.
     * 
     * @param  Request       $request
     * @param  \App\Tenancy  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDiscounts(Request $request, $id)
    {
        $this->tenancies->updateDiscounts($request->discount_id, $id);
        return back();
    }

    /**
     * Archive the tenancy.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $this->tenancies->archiveTenancy($id);
        return back();
    }

    /**
     * Record the tenants having vacated a tenancy.
     * 
     * @param  TenantsVacatedRequest $request
     * @param  integer               $id
     * @return \Illuminate\Http\Response]
     */
    public function tenantsVacated(TenantsVacatedRequest $request, $id)
    {
        $this->tenancies->tenantsVacated($request->vacated_on, $id);
        return back();
    }
}
