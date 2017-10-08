<?php

namespace App\Http\Controllers;

use App\Gas;
use App\Invoice;
use App\Payment;
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
        $managed_tenancies = Tenancy::isActive()->whereIn('service_id', $managed_services)->get();

        $rent_received = Payment::rentPayments()
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->get()
            ->sum('amount');

        $commission = Invoice::has('statements')
            ->whereNotNull('paid_at')
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->with('statements','items','items.taxRate')
            ->get()
            ->sum('total');

        $invoice_income = Invoice::doesntHave('statements')
            ->whereNotNull('paid_at')
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->with('items','items.taxRate')
            ->get()
            ->sum('total');

        $gas_expired = Gas::isExpired()->count();

    	return view('dashboard.index', compact(
            'overdue_tenancies',
            'active_tenancies',
            'managed_tenancies',
            'rent_received',
            'commission',
            'invoice_income',
            'gas_expired'
        ));
    }
}
