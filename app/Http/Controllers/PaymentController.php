<?php

namespace App\Http\Controllers;

use App\Repositories\EloquentPaymentsRepository;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * @var  App\Repositories\EloquentPaymentsRepository
     */
    protected $payments;

    /**
     * Create a new controller instance.
     * 
     * @param   EloquentPaymentsRepository $payments
     * @return  void
     */
    public function __construct(EloquentPaymentsRepository $payments)
    {
        $this->payments = $payments;
        $this->middleware('auth');
    }

    /**
     * Display a listing of all rent payments received.
     *
     * @return \Illuminate\Http\Response
     */
    public function rentPayments()
    {
        $payments = $this->payments->getRentPaymentsPaged();
        $title = 'Rent Payments';

        return view('payments.index', compact('payments','title'));
    }

    /**
     * Search through the resource and display the results.
     * 
     * @param  \Illuminate\Http\Requests $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $payments = $this->payments->search($request->search_term);
        $title = 'Search Results';

        return view('payments.index', compact('payments','title'));
    }
}
