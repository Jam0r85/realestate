<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatementPaymentSentRequest;
use App\Services\StatementService;
use App\StatementPayment;
use Illuminate\Http\Request;

class StatementPaymentController extends BaseController
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
    public function index()
    {
    	$payments = StatementPayment::whereNotNull('sent_at')->latest('sent_at')->paginate();
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
        $unsent = StatementPayment::whereNull('sent_at')->latest()->get();
        $groups = $unsent->groupBy('group')->sortBy('bank_account.account_name');
    	return view('statement-payments.unsent', compact('groups'));
    }

    /**
     * Mark the provided statement payments as sent.
     * 
     * @param \App\Http\Requests\StatementPaymentSentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function markSent(StatementPaymentSentRequest $request)
    {
        $service = new StatementService();
        $service->setStatementPaymentsSent($request->payments);

        $this->successMessage('The statement payments were marked as being sent');

        return back();
    }
}
