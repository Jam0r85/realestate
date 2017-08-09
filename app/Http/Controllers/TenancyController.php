<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatementRequest;
use App\Http\Requests\StoreTenancyRentPaymentRequest;
use App\Http\Requests\StoreTenancyRequest;
use App\Http\Requests\TenantsVacatedRequest;
use App\Services\PaymentService;
use App\Services\StatementService;
use App\Services\TenancyService;
use App\Tenancy;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TenancyController extends BaseController
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
        $tenancies = Tenancy::latest()->paginate();
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
        $tenancies = Tenancy::where('is_overdue', 1)->latest()->get();
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
        $tenancies = Tenancy::search($request->search_term)->get();
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
        $service = new TenancyService();
        $tenancy = $service->createTenancy($request->input());

        $this->successMessage('The tenancy was created');

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
        $tenancy = Tenancy::withTrashed()->findOrFail($id);
        return view('tenancies.show.' . $section, compact('tenancy'));
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
        $service = new PaymentService();
        $service->createTenancyRentPayment($request->input(), $id);

        $this->successMessage('The payment was recorded');

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
        $service = new StatementService();
        $service->createStatement($request->input(), $id);

        $this->successMessage('The statement was created');

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
        $service = new StatementService();
        $service->createOldStatement($request->input(), $id);

        $this->successMessage('The old statement was created');

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
        $tenancy = Tenancy::findOrFail($id);
        $tenancy->deleted_at = Carbon::now();
        $tenancy->save();

        $this->successMessage('The tenancy was archived');

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
        $tenancy = Tenancy::findOrFail($id);
        $tenancy->vacated_on = $request->vacated_on;
        $tenancy->save();

        $this->successMessage('The tenants were recorded as vacating');

        return back();
    }
}
