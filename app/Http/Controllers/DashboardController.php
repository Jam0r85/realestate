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
	 * Display the dashboard.
	 * 
	 * @return \Illuminate\Http\Response
	 */
    public function index()
    {
        $managed_services = Service::where('charge', '>', '0.00')->pluck('id')->toArray();
        
        $overdue_tenancies = Tenancy::overdue()->count();
        $active_tenancies = Tenancy::active()->count();
        $managed_tenancies = Tenancy::active()->whereIn('service_id', $managed_services)->get();

        $rent_received = Payment::forRent()
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->get()
            ->sum('amount');

        $invoices = Invoice::with('statements','items','items.taxRate')
            ->whereYear('paid_at', date('Y'))
            ->whereMonth('paid_at', date('m'))
            ->get();

        $invoice_total = $commission_total = 0;

        foreach ($invoices as $invoice) {
            if ($invoice->has('statements')) {
                $commission_total += $invoice->total;
            } else {
                $invoice_total += $invoice->total;
            }
        }

        $gas_expired = Gas::isExpired()->count();

    	return view('dashboard.index', compact(
            'overdue_tenancies',
            'active_tenancies',
            'managed_tenancies',
            'rent_received',
            'commission_total',
            'invoice_total',
            'gas_expired'
        ));
    }
}
