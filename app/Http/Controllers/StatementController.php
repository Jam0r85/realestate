<?php

namespace App\Http\Controllers;

use App\Events\StatementCreated;
use App\Http\Requests\ExpenseStoreRequest;
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
     * Create a new controller instance.
     * 
     * @param   EloquentStatementsRepository $statements
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
        $statements = Statement::whereNotNull('sent_at')->latest()->paginate();
        $unsent_statements = Statement::where('sent_at', null)->orWhere('paid_at', null)->latest()->get();

        $unsent_statements->load('tenancy','tenancy.property','tenancy.tenants','users');
        $statements->load('tenancy','tenancy.property','tenancy.tenants');

        $title = 'Statements List';

        return view('statements.index', compact('statements','unsent_statements','title'));
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

        $statements = Statement::search(Session::get('statements_search_term'))->get();
        $statements->sortBy('period_start');
        $title = 'Search Results';

        return view('statements.index', compact('statements','title'));
    }

    /**
     * Store a new statement into storage.
     * 
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(StatementStoreRequest $request)
    {
        $tenancy = Tenancy::withTrashed()->findOrFail($request->tenancy_id);

        $statement = new Statement();
        $statement->period_start = $request->period_start ?? $tenancy->nextStatementDate();
        $statement->period_end = $request->period_end;
        $statement->amount = $request->amount;

        $tenancy->storeStatement($statement);

        event(new StatementCreated($statement));

        $this->successMessage('The statement was created');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Statement  $statement
     * @return \Illuminate\Http\Response
     */
    public function show($id, $section = 'layout')
    {
        $statement = Statement::withTrashed()->findOrFail($id);
        return view('statements.show.' . $section, compact('statement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http|Requests\UpdateStatementRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStatementRequest $request, $id)
    {
        $statement = Statement::withTrashed()->findOrFail($id);

        $statement->created_at = $request->created_at;
        $statement->period_start = $request->period_start;
        $statement->period_end = $request->period_end;
        $statement->amount = $request->amount;

        $statement->save();

        $this->successMessage('The statement was updated');

        return back();
    }

    /**
     * Update whether a statement is paid or not.
     *
     * @param [type] $[name] [<description>]
     * @param  \App\Repositories\EloquentStatementsRepository $id
     * @return Illuminate\Http\Response
     */
    public function updatePaid(Request $request, $id)
    {
        $statement = Statement::withTrashed()->findOrFail($id);

        $statement->paid_at = $request->paid_at;

        $statement->save();

        $this->successMessage('The statement\'s paid date was updated');

        return back();
    }

    /**
     * Toggle a statement as being sent or unsent.
     * 
     * @param integer $id
     * @return Illuminate\Http\Response
     */
    public function toggleSent($id)
    {
        $service = new StatementService();
        $result = $service->toggleStatementSent($id);

        $this->successMessage('The statement was marked as ' . $result);

        return back();
    }

    /**
     * Send the statements to the owners.
     * 
     * @param \App\Http\Requests\StatementSendRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function send(StatementSendRequest $request, $id)
    {
        $statement = Statement::findOrFail($id);

        $statement->send();

        $this->successMessage('The statement was sent to the landlords');
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

        $this->successMessage('The invoice item was created');

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

        $this->successMessage('The expense item was added');

        return back();
    }

   /**
    * Create the payments for the statement.
    * 
    * @param integer $id
    * @return \Illuminate\Http\Response
    */
    public function createPayments($id)
    {
        $service = new StatementService();
        $service->createStatementPayments($id);

        $this->successMessage('The statement payments were created');

        return back();
    }

    /**
     * Archive the statement.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $statement = Statement::findOrFail($id);
        $statement->delete();

        $this->successMessage('The statement was archived');

        return back();
    }

    /**
     * Restore the statement.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $statement = Statement::onlyTrashed()->findOrFail($id);
        $statement->restore();

        $this->successMessage('The statement was restored');

        return back();
    }

    /**
     * Destroy the statement.
     *
     * @param \Illuminate\Http\Request $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $statement = Statement::withTrashed()->findOrFail($id);

        if ($request->has('paid_payments')) {
            $statement->payments()->whereNotNull('sent_at')->delete();
        }

        if ($request->has('unpaid_payments')) {
            $statement->payments()->whereNull('sent_at')->delete();
        }

        $statement->forceDelete();

        $this->successMessage('The statement was destroyed');
        return redirect()->route('statements.index');
    }
}
