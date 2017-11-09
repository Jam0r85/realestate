<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOldStatementRequest;
use App\Http\Requests\StoreRentAmountRequest;
use App\Http\Requests\StoreStatementRequest;
use App\Http\Requests\StoreTenancyRentPaymentRequest;
use App\Http\Requests\StoreTenancyRequest;
use App\Http\Requests\TenancyArchiveRequest;
use App\Http\Requests\TenantsVacatedRequest;
use App\Notifications\RentPaymentReceived;
use App\Services\PaymentService;
use App\Services\StatementService;
use App\Services\TenancyService;
use App\Tenancy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

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
    public function index($section = 'index', $view = 'index')
    {
        $tenancies = Tenancy::with('property','tenants','currentRent','service','deposit','rent_payments')->latest();

        if ($section == 'index') {
            $tenancies = $tenancies->paginate();            
            $title = 'Tenancies List';
        }

        if ($section == 'has-rent') {
            $tenancies = $tenancies->hasRent()->paginate();
            $title = 'Tenancies With Rent';
        }

        if ($section == 'owes-rent') {
            $tenancies = $tenancies->owesRent()->paginate();
            $title = 'Tenancies Owing Rent';
        }

        if ($section == 'overdue') {
            $tenancies = $tenancies->isOverdue()->get()->sortByDesc('days_overdue');
            $title = 'Overdue Tenancies';
        }

        if ($section == 'owes-deposit') {
            $tenancies->owesDeposit()->paginate();
            $title = 'Tenancies Owing Deposit';
        }

        return view('tenancies.' . $view, compact('tenancies','title'));
    }

    /**
     * Display a list of archived tenancies.
     * 
     * @return \Illuminate\Http\Response
     */
    public function archived()
    {
        $tenancies = Tenancy::with('property','tenants','currentRent','service','deposit')->onlyTrashed()->paginate();
        $title = 'Archived Tenancies';

        return view('tenancies.index', compact('tenancies','title'));
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

        $tenancies = Tenancy::search(Session::get('tenancies_search_term'))->get();
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
    public function show($id, $section = 'layout')
    {
        $tenancy = Tenancy::withTrashed()->findOrFail($id);
        $tenancy->load('deposit.payments','deposit.payments.method');
        
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
        $tenancy = Tenancy::findOrFail($id);

        $service = new PaymentService();
        $payment = $service->createTenancyRentPayment($request->input(), $id);
        $message = 'The payment was recorded';

        if ($request->has('send_receipt_to_tenants')) {
            Notification::send($tenancy->tenants, new RentPaymentReceived($payment));
            $message .= ' and the receipt was sent to the tenants';
        }

        $this->successMessage($message);

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
        $statement = $service->createStatement($request->input(), $id);

        $this->successMessage('The statement was created');

        return redirect()->route('statements.show', $statement);
    }

    /**
     * Store an old tenancy rental statement in storage.
     * 
     * @param  StoreTenancyRentPaymentRequest $request
     * @param  \App\Tenancy                   $id
     * @return \Illuminate\Http\Response
     */
    public function createOldRentalStatement(StoreOldStatementRequest $request, $id)
    {
        $service = new StatementService();
        $service->createOldStatement($request->input(), $id);

        $this->successMessage('The old statement was created');

        return back();
    }

    /**
     * Store a new rent amount in storage.
     * 
     * @param \App\Http\Requests\StoreRentAmountRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function createRentAmount(StoreRentAmountRequest $request, $id)
    {
        $tenancy = Tenancy::findOrFail($id);
        
        $service = new TenancyService();
        $service->createRentAmount($request->input(), $tenancy);

        // Create an agreement at the same time?
        if ($request->has('create_agreement')) {
            $service->createTenancyAgreement($request->input(), $tenancy);
        }

        $this->successMessage('The rent amount was recorded');

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
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function archive(TenancyArchiveRequest $request, $id)
    {
        $tenancy = Tenancy::findOrFail($id);
        $tenancy->delete();

        $tenancy->deposit->delete();

        $this->successMessage('The tenancy "' . $tenancy->name . '" was archived');

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

        $this->successMessage('The tenants were recorded as vacating');

        return back();
    }
}
