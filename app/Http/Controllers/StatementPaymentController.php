<?php

namespace App\Http\Controllers;

use App\Events\ExpenseStatementPaymentWasSaved;
use App\Events\ExpenseStatementPaymentWasSent;
use App\Events\Expenses\ExpenseUpdateBalances;
use App\Events\InvoiceStatementPaymentWasSaved;
use App\Events\InvoiceStatementPaymentWasSent;
use App\Events\Invoices\InvoiceUpdateBalances;
use App\Events\LandlordStatementPaymentWasSaved;
use App\Http\Requests\StatementPaymentSentRequest;
use App\Http\Requests\StatementPaymentStoreRequest;
use App\Http\Requests\StatementPaymentUpdateRequest;
use App\Statement;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatementPaymentController extends BaseController
{
    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    public $model = 'App\StatementPayment';

    /**
     * Display a listing of statement payments.
     * 
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        $unsent_payments = $this->repository
                ->with('statement','statement.tenancy','statement.tenancy.property','bank_account','parent')
                ->whereNull('sent_at')
                ->latest()
                ->get()
                ->groupBy('group')
                ->sortBy('bank_account.account_name');

    	$sent_payments = $this->repository
            ->with('statement','statement.tenancy','statement.tenancy.property','users','bank_account')
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
        $sent_at = $request->has('sent_at') ? $request->sent_at : null;

        // Invoice Payments
        if (count($statement->invoices)) {
            foreach ($statement->invoices as $invoice) {
                $payment = $this->repository::updateOrCreate(
                    ['statement_id' => $statement->id, 'parent_type' => 'invoices', 'parent_id' => $invoice->id],
                    [
                        'amount' => $statement->present()->invoicesTotal,
                        'sent_at' => $sent_at,
                        'bank_account_id' => get_setting('company_bank_account_id')
                    ]
                );

                // Attach the invoice users to this payment
                $payment->users()->sync(get_setting('company_user_id'));

                event (new InvoiceStatementPaymentWasSaved($payment));
            }
        } else {
            $this->repository
                ->where('statement_id', $statement->id)
                ->where('parent_type', 'invoices')
                ->delete();
        }

        // Expense Payments
        if (count($statement->expenses)) {
            foreach ($statement->expenses as $expense) {

                $payment = $this->repository::updateOrCreate(
                    ['statement_id' => $statement->id, 'parent_type' => 'expenses', 'parent_id' => $expense->id],
                    [
                        'amount' => $expense->pivot->amount,
                        'sent_at' => $sent_at,
                        'bank_account_id' => $expense->contractor->getSetting('contractor_bank_account_id')
                    ]
                );

                // Attach the expense contractor to this payment
                $payment->users()->sync($expense->contractor);

                event (new ExpenseStatementPaymentWasSaved($payment));
            }
        } else {
            $this->repository
                ->where('statement_id', $statement->id)
                ->where('parent_type', 'expenses')
                ->delete();
        }

        // Landlord Payment
        $payment = $this->repository::updateOrCreate(
            ['statement_id' => $statement->id, 'parent_type' => null],
            [
                'amount' => $statement->present()->landlordBalanceTotal,
                'sent_at' => $sent_at,
                'bank_account_id' => $statement->property()->bank_account_id
            ]
        );

        // Attach the statement users to this payment
        $payment->users()->sync($statement->users);

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
            ->findOrFail($id);

        $payment
            ->fill($request->input())
            ->save();

        $payment
            ->users()->sync($request->users);

        if ($payment->present()->parentName == 'Invoice') {
            event(new InvoiceStatementPaymentWasSaved($payment));
        }

        if ($payment->present()->parentName == 'Expense') {
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
            ->findOrFail($id);

        $payment
            ->fill(['sent_at' => Carbon::now()])
            ->saveWithMessage('was sent');

        if ($payment->present()->parentName == 'Invoice') {
            event(new InvoiceStatementPaymentWasSent($payment));
        }

        if ($payment->present()->parentName == 'Expense') {
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
