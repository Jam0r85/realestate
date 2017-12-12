<?php

namespace App\Http\Controllers;

use App\Events\StatementCreated;
use App\Events\Tenancies\TenancyUpdateStatus;
use App\Http\Requests\ExpenseStoreRequest;
use App\Http\Requests\StatementDestroyRequest;
use App\Http\Requests\StatementSendRequest;
use App\Http\Requests\StatementStoreRequest;
use App\Http\Requests\StoreInvoiceItemRequest;
use App\Http\Requests\UpdateStatementRequest;
use App\Mail\StatementByEmail;
use App\Services\StatementService;
use App\Tenancy;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class StatementController extends BaseController
{
    public $model = 'App\Statement';

    /**
     * Display a listing of the statements.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->all()) {
            $request->request->add(['sent' => false]);
        }

        $statements = $this->repository
            ->with('tenancy','tenancy.property','tenancy.users','payments','users')
            ->withTrashed()
            ->filter($request->all())
            ->paginateFilter();

        return view('statements.index', compact('statements'));
    }

    /**
     * Store a new statement into storage.
     *
     * @param  \App\Tenancy  $tenancy
     * @param  \App\Http\Requests\StatementStoreRequest  $request
     * @return. \Illuminate\Http\Response
     */
    public function store(StatementStoreRequest $request, Tenancy $tenancy)
    {
        $statement = $this->repository;
        $statement->period_start = $request->period_start ?? $tenancy->present()->nextStatementStartDate;
        $statement->period_end = $request->period_end;
        $statement->amount = $request->amount;

        $tenancy->storeStatement($statement);

        event(new StatementCreated($statement));

        return back();
    }

    /**
     * Display the specified statement.
     *
     * @param  \App\Statement  $id
     * @return  \Illuminate\Http\Response
     */
    public function show($id, $section = 'layout')
    {
        $statement = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('statements.show.' . $section, compact('statement'));
    }

    /**
     * Update the specified statement in storage.
     *
     * @param  \App\Http|Requests\UpdateStatementRequest  $request
     * @param  \App\Statement  $statement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStatementRequest $request, $id)
    {
        $statement = $this->repository
            ->withTrashed()
            ->findOrFail($id)
            ->fill($request->input())
            ->save();

        event(new TenancyUpdateStatus($statement->tenancy));

        return back();
    }

    /**
     * Send the statements to the owners.
     * 
     * @param  \App\Http\Requests\StatementSendRequest  $request
     * @param  \App\Statement  $id
     * @return  \Illuminate\Http\Response
     */
    public function send(StatementSendRequest $request, $id)
    {
        $statement = $this->repository
            ->findOrFail($id)
            ->send();

        return back();
    }

   /**
    * Create a new invoice item for the statement.
    * 
    * @param \App\Http\Requests\StoreInvoiceItemRequest $request
    * @param integer $id
    * @return \Illuminate\Http\Response
    */
    public function createInvoiceItem(StoreInvoiceItemRequest $request, $id)
    {
        $service = new StatementService();
        $service->createInvoiceItem($request->input(), $id);

        return back();
    }

   /**
    * Create a new expense item for the statement.
    * 
    * @param \App\Http\Requests\StoreExpenseRequest $request
    * @param integer $id
    * @return \Illuminate\Http\Response
    */
    public function createExpenseItem(ExpenseStoreRequest $request, $id)
    {
        $service = new StatementService();
        $service->createExpenseItem($request->input(), $id);

        return back();
    }

    /**
     * Destroy the statement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Statement  $statement
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $statement = $this->repository
            ->findOrFail($id);
            
        if ($request->has('paid_payments')) {
            $statement->payments()->whereNotNull('sent_at')->delete();
        }

        if ($request->has('unpaid_payments')) {
            $statement->payments()->whereNull('sent_at')->delete();
        }

        if ($request->has('invoice')) {
            $statement->invoices()->forceDelete();
        }

        $statement->forceDelete();

        // We need to update the tenancy balances.
        // Surely there is a better place to put this?
        event(new TenancyUpdateStatus($statement->tenancy));

        return redirect()->route('statements.index');
    }
}
