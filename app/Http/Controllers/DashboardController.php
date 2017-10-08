<?php

namespace App\Http\Controllers;

use App\Gas;
use App\Service;
use App\Tenancy;
use Illuminate\Http\Request;

class DashboardController extends Controller
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
	 * Display the dashboard.
	 * 
	 * @return \Illuminate\Http\Response
	 */
    public function index()
    {
        $managed_services = Service::where('charge', '>', '0.00')->pluck('id')->toArray();

        $overdue_tenancies = Tenancy::isOverdue()->count();
        $active_tenancies = Tenancy::isActive()->count();
        $managed_tenancies = Tenancy::whereIn('service_id', $managed_services)->count();

        $gas_expired = Gas::isExpired()->count();

    	return view('dashboard.index', compact(
            'overdue_tenancies',
            'active_tenancies',
            'managed_tenancies',
            'gas_expired'
        ));
    }
}
