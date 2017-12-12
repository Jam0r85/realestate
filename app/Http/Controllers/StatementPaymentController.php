<?php

namespace App\Http\Controllers;

use App\Events\Invoices\InvoiceUpdateBalancesEvent;
use App\Http\Requests\StatementPaymentSentRequest;
use App\Http\Requests\StatementPaymentStoreRequest;
use App\Http\Requests\StatementPaymentUpdateRequest;
use App\Services\StatementService;
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
     * @param  \App\Statement  $statement  the statement that we are generating payments for
     * @return  \Illuminate\Http\Response
     */
    public function store(StatementPaymentStoreRequest $request, Statement $statement)
    {
        $sent_at = $request->has('sent_at') ? $request->sent_at : null;

        // Invoice Payments
        if (count($statement->invoices)) {
            foreach ($statement->invoices as $invoice) {
                $this->repository::updateOrCreate(
                    ['statement_id' => $statement->id, 'parent_type' => 'invoices', 'parent_id' => $invoice->id],
                    [
                        'amount' => $statement->present()->invoicesTotal,
                        'sent_at' => $sent_at
                    ]
                );

                event(new InvoiceUpdateBalancesEvent($invoice));
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

                $this->repository::updateOrCreate(
                    ['statement_id' => $statement->id, 'parent_type' => 'expenses', 'parent_id' => $expense->id],
                    [
                        'amount' => $expense->pivot->amount,
                        'sent_at' => $sent_at
                    ]
                );
            }
        } else {
            $this->repository
                ->where('statement_id', $statement->id)
                ->where('parent_type', 'expenses')
                ->delete();
        }

        // Landlord Payment
        $this->repository::updateOrCreate(
            ['statement_id' => $statement->id, 'parent_type' => null],
            [
                'amount' => $statement->present()->landlordBalanceTotal,
                'sent_at' => $sent_at,
                'bank_account_id' => $statement->property()->bank_account_id
            ]
        );

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
        $this->repository
            ->findOrFail($id)
            ->fill($request->input())
            ->save();

        return back();
    }

    /**
     * Download the statement payments as a PDF.
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
