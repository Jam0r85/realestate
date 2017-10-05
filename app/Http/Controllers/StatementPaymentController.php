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
        $unsent_payments = StatementPayment::whereNull('sent_at')->latest()->get();
        // $unsent_payments->load('statement','statement.tenancy.property','users','bank_account','parent');

    	$sent_payments = StatementPayment::whereNotNull('sent_at')->latest('sent_at')->paginate();
        $sent_payments->load('statement','statement.tenancy','statement.tenancy.property','users','bank_account');

        if (count($unsent_payments)) {
            $unsent_payments = $unsent_payments->groupBy('group')->sortBy('bank_account.account_name');
        }

    	return view('statement-payments.index', compact('unsent_payments','sent_payments'));
    }

    /**
     * Download the statement payments as a PDF.
     * 
     * @return \Illuminate\Http\Response
     */
    public function print()
    {
        $unsent_payments = StatementPayment::whereNull('sent_at')->latest()->get();

        if (!count($unsent_payments)) {
            return back();
        }

        $unsent_payments = $unsent_payments->groupBy('group')->sortBy('bank_account.account_name');
        return view('statement-payments.print', compact('unsent_payments'));
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
