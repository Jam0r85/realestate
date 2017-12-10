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
use App\Statement;
use App\Tenancy;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class StatementController extends BaseController
{
    /**
     * Display a listing of the statements.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $statements = Statement::with('tenancy','tenancy.property','tenancy.tenants','payments','users')
            ->withTrashed()
            ->filter($request->all())
            ->paginateFilter();

        return view('statements.index', compact('statements'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Clear the search term.
        if ($request && $request->has('clear_search')) {
            Session::forget('statements_search_term');
            return redirect()->route('statements.index');
        }

        Session::put('statements_search_term', $request->search_term);

        $searchResults = Statement::search(Session::get('statements_search_term'))->get();
        $searchResults->sortBy('period_start');
        $title = 'Search Results';

        return view('statements.index', compact('searchResults','title'));
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
        $statement = new Statement();
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
     * @param  \App\Statement  $statement
     * @return  \Illuminate\Http\Response
     */
    public function show(Statement $statement, $section = 'layout')
    {
        return view('statements.show.' . $section, compact('statement'));
    }

    /**
     * Update the specified statement in storage.
     *
     * @param  \App\Http|Requests\UpdateStatementRequest  $request
     * @param  \App\Statement  $statement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStatementRequest $request, Statement $statement)
    {
        $statement->created_at = $request->created_at;
        $statement->period_start = $request->period_start;
        $statement->period_end = $request->period_end;
        $statement->amount = $request->amount;
        $statement->send_by = $request->send_by;
        $statement->save();

        event(new TenancyUpdateStatus($statement->tenancy));

        return back();
    }

    /**
     * Send the statements to the owners.
     * 
     * @param  \App\Http\Requests\StatementSendRequest  $request
     * @param  \App\Statement  $statement
     * @return  \Illuminate\Http\Response
     */
    public function send(StatementSendRequest $request, Statement $statement)
    {
        $statement->send();
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
     * Archive the statement in storage.
     *
     * @param  \App\Statement  $statement
     * @return  \Illuminate\Http\Response
     */
    public function archive(Request $request, Statement $statement)
    {
        $statement->delete();
        return back();
    }

    /**
     * Restore the statement from storage.
     *
     * @param  \App\Statement  $statement
     * @return  \Illuminate\Http\Response
     */
    public function restore(Request $request, Statement $statement)
    {
        $statement->restore();
        return back();
    }

    /**
     * Destroy the statement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Statement  $statement
     * @return  \Illuminate\Http\Response
     */
    public function destroy(StatementDestroyRequest $request, Statement $statement)
    {
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
