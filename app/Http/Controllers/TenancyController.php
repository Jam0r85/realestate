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
use App\Tenancy;
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
        $tenancies = Tenancy::withTrashed()
            ->eagerLoading()
            ->filter($request->all())
            ->latest()
            ->paginateFilter();

        return view('tenancies.index', compact('tenancies'));
    }

    /**
     * Search through the resource and display the results.
     * 
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function search(Request $request)
    {
        // Clear the search term.
        if ($request && $request->has('clear_search')) {
            Session::forget('tenancies_search_term');
            return redirect()->route('tenancies.index');
        }

        Session::put('tenancies_search_term', $request->search_term);

        $searchResults = Tenancy::search(Session::get('tenancies_search_term'))->get();
        $title = 'Search Results';

        return view('tenancies.index', compact('searchResults','title'));
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
     * @param \App\Http\Requests\TenancyStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TenancyStoreRequest $request)
    {
        $property = Property::findOrFail($request->property_id);

        $tenancy = new Tenancy();
        $tenancy->user_id = Auth::user()->id;
        $tenancy->service_id = $request->service_id;

        $property->tenancies()->save($tenancy);

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
        $tenancy->tenants()->attach($request->tenants);

        return redirect()->route('tenancies.show', $tenancy->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tenancy  $tenancy
     * @return \Illuminate\Http\Response
     */
    public function show($id, $page = 'layout')
    {
        $tenancy = Tenancy::withTrashed()->findOrFail($id);

        $payments = $tenancy->rent_payments()->with('method','owner','users')->paginate();
        $statements = $tenancy->statements()->with('invoices','invoices.invoiceGroup','invoices.items','invoices.items.taxRate','expenses','payments')->paginate();
        $rents = $tenancy->rents()->with('owner')->get();
        
        return view('tenancies.pages.' . $page, compact('tenancy','statements','payments','rents'));
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
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function archive(TenancyArchiveRequest $request, $id)
    {
        $tenancy = Tenancy::findOrFail($id);
        $tenancy->delete();
        $tenancy->deposit->delete();
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
