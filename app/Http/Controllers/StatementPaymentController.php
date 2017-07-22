<?php

namespace App\Http\Controllers;

use App\Repositories\EloquentStatementPaymentsRepository;
use Illuminate\Http\Request;

class StatementPaymentController extends Controller
{
    /**
     * @var  App\Repositories\EloquentStatementPaymentsRepository
     */
    protected $statement_payments;

    /**
     * Create a new controller instance.
     * 
     * @param   EloquentStatementPaymentsRepository $statements
     * @return  void
     */
    public function __construct(EloquentStatementPaymentsRepository $statement_payments)
    {
        $this->middleware('auth');
        $this->statement_payments = $statement_payments;
    }

    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$payments = $this->statement_payments->getSentPaged();
    	$title = 'Sent Statement Payments';

    	return view('statement-payments.index', compact('payments','title'));
    }

    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function unsent()
    {
    	$payments = $this->statement_payments->getUnsentPaged();
    	return view('statement-payments.unsent', compact('payments'));
    }
}
