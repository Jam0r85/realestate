<?php

namespace App\Http\Controllers;

use App\Events\ExpenseStatementPaymentWasSaved;
use App\Events\ExpenseStatementPaymentWasSent;
use App\Events\Expenses\ExpenseUpdateBalances;
use App\Events\InvoiceStatementPaymentWasSaved;
use App\Events\InvoiceStatementPaymentWasSent;
use App\Events\Invoices\InvoiceUpdateBalances;
use App\Events\LandlordStatementPaymentWasSaved;
use App\Events\StatementPaymentWasSent;
use App\Http\Requests\StatementPaymentSentRequest;
use App\Http\Requests\StatementPaymentStoreRequest;
use App\Http\Requests\StatementPaymentUpdateRequest;
use App\Statement;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatementPaymentController extends BaseController
{
    /**
     * Display a listing of statement payments.
     * 
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        $unsent_payments = $this->repository
                ->with('statement','statement.tenancy','statement.tenancy.property','bank_account','parent','users')
                ->whereNull('sent_at')
                ->latest()
                ->get()
                ->groupBy('group')
                ->sortBy('bank_account.account_name');

    	$sent_payments = $this->repository
            ->with('statement','statement.tenancy','statement.tenancy.property','parent','users','bank_account')
            ->whereNotNull('sent_at')
            ->latest('sent_at')
            ->paginate();

    	return view('statement-payments.index', compact('unsent_payments','sent_payments'));
    }

    /**
     * Store a new statement payment in storage.
     * 
     * @param  \App\Http\Requests\StorePaymentStoreRequest  $request
     * @param  \App\Statement  $statement
     * @return \Illuminate\Http\Response
     */
    public function store(StatementPaymentStoreRequest $request, Statement $statement)
    {
        $this->repository
            ->createPayments($statement);

        return back();
    }

    /**
     * Show the statement payment.
     * 
     * @param  \App\StatementPayment  $id
     * @return  \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = $this->repository
            ->findOrFail($id);

        return view('statement-payments.show', compact('payment'));
    }

    /**
     * Show the form for editing a statement payment.
     * 
     * @param  \App\StatementPayment  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = $this->repository
            ->findOrFail($id);

        return view('statement-payments.edit', compact('payment'));
    }

    /**
     * Update the statement payment in storage.
     * 
     * @param  \App\Http\Request\StatementPaymentUpdateRequest  $request 
     * @param  \App\StatementPayment  $id
     * @return  \Illuminate\Http\Response
     */
    public function update(StatementPaymentUpdateRequest $request, $id)
    {
        $payment = $this->repository
            ->findOrFail($id)
            ->fill($request->input())
            ->save();

        if ($request->has('users')) {
            $payment
                ->users()->sync($request->users);
        }

        if (model_name($payment->parent) == 'Invoice') {
            event(new InvoiceStatementPaymentWasSaved($payment));
        }

        if (model_name($payment->parent) == 'Expense') {
            event(new ExpenseStatementPaymentWasSaved($payment));
        }

        return back();
    }

    /**
     * Send the given statement payment.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $payment
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request, $id)
    {
        $payment = $this->repository
            ->findOrFail($id)
            ->fill(['sent_at' => Carbon::now()])
            ->saveWithMessage('was sent');

        event(new StatementPaymentWasSent($payment));

        if (model_name($payment->parent) == 'Invoice') {
            event(new InvoiceStatementPaymentWasSent($payment));
        }

        if (model_name($payment->parent) == 'Expense') {
            event(new ExpenseStatementPaymentWasSent($payment));
        }

        return back();
    }

    /**
     * Show a printable version of unsent statement payments.
     * 
     * @return \Illuminate\Http\Response
     */
    public function print()
    {
        $unsent_payments = $this->repository
            ->whereNull('sent_at')
            ->latest()
            ->get();

        if (!count($unsent_payments)) {
            return back();
        }

        $unsent_payments = $unsent_payments->groupBy('group')->sortBy('bank_account.account_name');
        return view('statement-payments.print', compact('unsent_payments'));
    }
}
