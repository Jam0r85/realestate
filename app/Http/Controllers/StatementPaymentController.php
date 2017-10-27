<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatementPaymentSentRequest;
use App\Http\Requests\StatementPaymentUpdateRequest;
use App\Services\StatementService;
use App\StatementPayment;
use Carbon\Carbon;
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

        if (count($unsent_payments)) {
            $unsent_payments = $unsent_payments->groupBy('group')->sortBy('bank_account.account_name');
        }

    	$sent_payments = StatementPayment::with('statement','statement.tenancy','statement.tenancy.property','users','bank_account')
            ->whereNotNull('sent_at')
            ->latest('sent_at')
            ->paginate();

    	return view('statement-payments.index', compact('unsent_payments','sent_payments'));
    }

    /**
     * Show the statement payment.
     * 
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = StatementPayment::findOrFail($id);
        return view('statement-payments.show', compact('payment'));
    }

    /**
     * Show the form for editing a statement payment.
     * 
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = StatementPayment::findOrFail($id);
        return view('statement-payments.edit', compact('payment'));
    }

    /**
     * Update the statement payment in storage.
     * 
     * @param \App\Http\Request\StatementPaymentUpdateRequest $request 
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(StatementPaymentUpdateRequest $request, $id)
    {
        $payment = StatementPayment::findOrFail($id);
        $payment->sent_at = $request->sent_at;
        $payment->save();

        $this->successMessage('The changes were saved for the payment');
        return back();
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
     * Update the given statement payments as being sent.
     * 
     * @param \App\Http\Requests\StatementPaymentSentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function markSent(StatementPaymentSentRequest $request)
    {
        StatementPayment::whereIn('id', $request->payments)
            ->update([
                'sent_at' => Carbon::now()
            ]);

        $this->successMessage('The statement ' . str_plural('payment', count($request->payments)) . ' ' . str_plural('was', count($request->payments)) . ' marked as being sent');

        return back();
    }
}
