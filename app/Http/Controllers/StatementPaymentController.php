<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatementPaymentSentRequest;
use App\Http\Requests\StatementPaymentStoreRequest;
use App\Http\Requests\StatementPaymentUpdateRequest;
use App\Services\StatementService;
use App\Statement;
use App\StatementPayment;
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
        $unsent_payments = StatementPayment::whereNull('sent_at')->latest()->get();

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
     * Store a new statement payment in storage.
     * 
     * @param  \App\Http\Requests\StorePaymentStoreRequest  $request
     * @param  \App\Statement  $statement  the statement that we are generating payments for
     * @return  \Illuminate\Http\Response
     */
    public function store(StatementPaymentStoreRequest $request, Statement $statement)
    {
        $sent_at = $request->has('sent_at') ? $request->sent_at : null;

        // Invoice Payments
        if (count($statement->invoices)) {
            foreach ($statement->invoices as $invoice) {
                StatementPayment::updateOrCreate(
                    ['statement_id' => $statement->id, 'parent_type' => 'invoices', 'parent_id' => $invoice->id],
                    [
                        'amount' => $statement->getInvoiceTotal(),
                        'sent_at' => $sent_at
                    ]
                );
            }
        } else {
            StatementPayment::where('statement_id', $statement->id)->where('parent_type', 'invoices')->delete();
        }

        // Expense Payments
        if (count($statement->expenses)) {
            foreach ($statement->expenses as $expense) {

                StatementPayment::updateOrCreate(
                    ['statement_id' => $statement->id, 'parent_type' => 'expenses', 'parent_id' => $expense->id],
                    [
                        'amount' => $expense->pivot->amount,
                        'sent_at' => $sent_at
                    ]
                );
            }
        } else {
            StatementPayment::where('statement_id', $statement->id)->where('parent_type', 'expenses')->delete();
        }

        // Landlord Payment
        StatementPayment::updateOrCreate(
            ['statement_id' => $statement->id, 'parent_type' => null],
            [
                'amount' => $statement->getLandlordAmount(),
                'sent_at' => $sent_at,
                'bank_account_id' => $statement->property()->bank_account_id
            ]
        );

        return back();
    }

    /**
     * Show the statement payment.
     * 
     * @param  \App\StatementPayment  $payment
     * @return  \Illuminate\Http\Response
     */
    public function show(StatementPayment $payment)
    {
        return view('statement-payments.show', compact('payment'));
    }

    /**
     * Show the form for editing a statement payment.
     * 
     * @param  \App\StatementPayment  $payment
     * @return  \Illuminate\Http\Response
     */
    public function edit(StatementPayment $payment)
    {
        return view('statement-payments.edit', compact('payment'));
    }

    /**
     * Update the statement payment in storage.
     * 
     * @param  \App\Http\Request\StatementPaymentUpdateRequest  $request 
     * @param  \App\StatementPayment  $payment
     * @return  \Illuminate\Http\Response
     */
    public function update(StatementPaymentUpdateRequest $request, StatementPayment $payment)
    {
        $payment->fill($request->input());
        $payment->save();

        return back();
    }

    /**
     * Remove the statement payment from storage.
     *
     * @param  \App\StatementPayment  $payment
     * @return  \Illuminate\Http\Response
     */
    public function destroy(StatementPayment $payment)
    {
        $payment->delete();
        return redirect()->route('statements.show', $payment->statement_id);
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
}
