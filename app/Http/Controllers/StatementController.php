<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendStatementsRequest;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\StoreInvoiceItemRequest;
use App\Http\Requests\UpdateStatementRequest;
use App\Services\StatementService;
use App\Statement;
use Illuminate\Http\Request;

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
        $title = 'Sent Statements List';

        return view('statements.index', compact('statements','title'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function unsent()
    {
        $statements = Statement::whereNull('sent_at')->latest()->get();
        return view('statements.unsent', compact('statements'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function unpaid()
    {
        $statements = Statement::whereNull('paid_at')->latest()->get();
        $title = 'Unpaid Statements List';

        return view('statements.unpaid', compact('statements','title'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $statements = Statement::search($request->search_term)->get();
        $title = 'Search Results';

        return view('statements.index', compact('statements','title'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Statement  $statement
     * @return \Illuminate\Http\Response
     */
    public function show($id, $section = 'items')
    {
        $statement = Statement::findOrFail($id);
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
        $service = new StatementService();
        $service->updateStatement($request->input(), $id);

        $this->successMessage('The statement was updated');

        return back();
    }

    /**
     * Toggle a statement as being paid or unpaid.
     *
     * @param [type] $[name] [<description>]
     * @param  \App\Repositories\EloquentStatementsRepository $id
     * @return Illuminate\Http\Response
     */
    public function togglePaid(Request $request, $id = null)
    {
        // Build a statements array.
        $statements = [];

        // Should the ID be provided, we add it to the array.
        if (!is_null($id)) {
            $statements[] = $id;
        }

        $service = new StatementService();
        $result = $service->toggleStatementsPaid($statements);

        $this->successMessage('The statement(s) were ' . $result);

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
     * @param \App\Http\Requests\SendStatementsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function send(SendStatementsRequest $request)
    {
        $service = new StatementService();
        $service->sendStatementsToOwners($request->statements);

        $this->successMessage('The statements were queued to be sent');

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
    public function createExpenseItem(StoreExpenseRequest $request, $id)
    {
        $service = new StatementService();
        $service->createExpenseItem($request->input(), $id);

        $this->successMessage('The expense item was created');

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
}
