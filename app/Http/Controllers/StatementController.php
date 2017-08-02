<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\StoreInvoiceItemRequest;
use App\Http\Requests\UpdateStatementRequest;
use App\Repositories\EloquentStatementsRepository;
use Illuminate\Http\Request;

class StatementController extends Controller
{
    /**
     * @var  App\Repositories\EloquentStatementsRepository
     */
    protected $statements;

    /**
     * Create a new controller instance.
     * 
     * @param   EloquentStatementsRepository $statements
     * @return  void
     */
    public function __construct(EloquentStatementsRepository $statements)
    {
        $this->middleware('auth');
        $this->statements = $statements;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statements = $this->statements->getSentPaged();
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
        $statements = $this->statements->getUnsentPaged();
        $title = 'Unsent Statements List';

        return view('statements.unsent', compact('statements','title'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function unpaid()
    {
        $statements = $this->statements->getUnpaidPaged();
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
        $statements = $this->statements->search($request->search_term);
        $title = 'Search Results';

        return view('statements.index', compact('statements','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Statement  $statement
     * @return \Illuminate\Http\Response
     */
    public function show($id, $section = 'items')
    {
        $statement = $this->statements->find($id);
        return view('statements.show.' . $section, compact('statement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Statement  $statement
     * @return \Illuminate\Http\Response
     */
    public function edit(Statement $statement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Statement  $statement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStatementRequest $request, $id)
    {
        $this->statements->updateStatement($request->input(), $id);
        return back();
    }

    /**
     * Toggle a statement as being paid or unpaid.
     * 
     * @param  \App\Repositories\EloquentStatementsRepository $id
     * @return Illuminate\Http\Response
     */
    public function togglePaid(Request $request, $id = null)
    {
        $statements = $request->statement_id;

        if ($id) {
            $statements[] = $id;
        }

        $this->statements->togglePaid($statements);
        return back();
    }

    /**
     * Toggle a statement as being sent or unsent.
     * 
     * @param  \App\Repositories\EloquentStatementsRepository $id
     * @return Illuminate\Http\Response
     */
    public function toggleSent($id)
    {
        $this->statements->toggleSent($id);
        return back();
    }

    /**
     * Send the provided statements.
     * 
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function send(Request $request)
    {
        $this->statements->sendStatements($request->statement_id);
        return back();
    }

   /**
    * Store a new invoice item for this rental statement.
    * 
    * @param  StoreInvoiceItem $request [description]
    * @param  [type]           $id      [description]
    * @return [type]                    [description]
    */
    public function createInvoiceItem(StoreInvoiceItemRequest $request, $id)
    {
        $this->statements->createInvoiceItem($request->input(), $id);
        return back();
    }

   /**
    * Store a new expense for this rental statement.
    * 
    * @param  StoreExpenseRequest $request
    * @param  App\Statement           $id
    * @return \Illuminate\Http\Response
    */
    public function createExpenseItem(StoreExpenseRequest $request, $id)
    {
        $this->statements->createExpenseItem($request->input(), $id);
        return back();
    }

   /**
    * Create the statement payments.
    * 
    * @param  [type]           $id      [description]
    * @return [type]                    [description]
    */
    public function createPayments($id)
    {
        $this->statements->createPayments($id);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Statement  $statement
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $this->statements->archiveStatement($id);
        return back();
    }
}
