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
        $overdue_tenancies = Tenancy::isOverdue()->get();
        $overdue_tenancies = $overdue_tenancies->sortByDesc('days_overdue');

    	return view('dashboard.index', compact('overdue_tenancies'));
    }
}
