<?php

namespace App\Http\Controllers;

use App\Agreement;
use App\Http\Requests\StoreOldStatementRequest;
use App\Http\Requests\StoreRentAmountRequest;
use App\Http\Requests\StoreStatementRequest;
use App\Http\Requests\StoreTenancyRentPaymentRequest;
use App\Http\Requests\TenancyArchiveRequest;
use App\Http\Requests\TenancyStoreRequest;
use App\Http\Requests\TenantsVacatedRequest;
use App\Notifications\TenantRentPaymentReceived;
use App\Property;
use App\TenancyRent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class TenancyController extends BaseController
{
    /**
     * The model for this controller.
     * 
     * @var string
     */
    public $model = 'App\Tenancy';

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->all()) {
            // Hide archived tenancies by default
            $request->request->add(['archived' => false]);
        }

        $tenancies = $this->repository
            ->withTrashed()
            ->eagerLoading()
            ->filter($request->all())
            ->latest()
            ->paginateFilter();

        return view('tenancies.index', compact('tenancies'));
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
     * @param  \App\Http\Requests\TenancyStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TenancyStoreRequest $request)
    {
        $property = Property::withTrashed()
            ->findOrFail($request->property_id);

        $tenancy = $this->repository
            ->fill($request->input());

        $property
            ->storeTenancy($tenancy);

        // Rent
        $rent = new TenancyRent;
        $rent->amount = $request->rent_amount;
        $rent->starts_at = $request->start_date;
        $tenancy->storeRentAmount($rent);

        // Agreement
        $agreement = new Agreement;
        $agreement->starts_at = $request->start_date;
        $agreement->length = $request->length;
        $tenancy->storeAgreement($agreement);

        // Attach the tenants
        $tenancy->users()->attach($request->tenants);

        return redirect()->route('tenancies.show', $tenancy->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $show
     * @return \Illuminate\Http\Response
     */
    public function show($id, $show = 'index')
    {
        $tenancy = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('tenancies.show', compact('tenancy','show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tenancy = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('tenancies.edit', compact('tenancy'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tenancy = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        $tenancy
            ->fill($request->input())
            ->save();

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
        $tenancy->is_overdue = $tenancy->checkWhetherOverdue();
        $tenancy->save();
        return back();
    }
}
