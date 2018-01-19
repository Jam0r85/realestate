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
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('list', $this->repository);
        
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
        $this->authorize('create', $this->repository);

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
        $this->authorize('create', $this->repository);

        $property = Property::withTrashed()
            ->findOrFail($request->property_id);

        $tenancy = $this->repository
            ->fill($request->input())
            ->setName($request->tenants);

        return dd($tenancy);

        $property
            ->storeTenancy($tenancy);

        // Rent
        $rent = new TenancyRent;
        $rent->amount = pounds_to_pence($request->rent_amount);
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

        $this->authorize('view', $tenancy);

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

        $this->authorize('update', $tenancy);

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

        $this->authorize('update', $tenancy);

        $tenancy
            ->fill($request->input())
            ->setOverdue(false)
            ->save();
            
        return back();
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function delete(Request $request, $id)
    {
        parent::delete($request, $id);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function forceDelete(Request $request, $id)
    {
        $tenancy = parent::forceDelete($request, $id);

        $tenancy->rents()->delete();
        $tenancy->agreements()->delete();

        if (count($tenancy->statements)) {
            foreach ($tenancy->statements as $statement) {
                $statement->invoices()->forceDelete();
                $statement->payments()->delete();
                $statement->forceDelete();
            }
        }

        return redirect()->route($this->indexRoute);
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
