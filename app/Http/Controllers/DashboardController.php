<?php

namespace App\Http\Controllers;

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
        $overdue_tenancies = Tenancy::isOverdue()->count();
        $active_tenancies = Tenancy::isActive()->count();

    	return view('dashboard.index', compact('overdue_tenancies','active_tenancies'));
    }
}
