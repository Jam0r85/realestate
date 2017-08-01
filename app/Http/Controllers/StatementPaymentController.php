<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatementPaymentSentRequest;
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
    	$groups = $this->statement_payments->getUnsentGrouped();
        // return dd($groups);
    	return view('statement-payments.unsent', compact('groups'));
    }

    /**
     * Search through the resource and display the results.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $payments = $this->statement_payments->search($request->search_term);
        $title = 'Search Results';

        return view('statement-payments.index', compact('payments','title'));
    }

    /**
     * Mark the provided statement payments as sent.
     * 
     * @param  StatementPaymentSentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function markSent(StatementPaymentSentRequest $request)
    {
        $this->statement_payments->sendPayments($request->payment_id);
        return back();
    }
}
