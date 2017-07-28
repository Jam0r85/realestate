<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceItemRequest;
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
        $send_statement = false;

        return view('statements.index', compact('statements','title','send_statement'));
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
        $send_statement = true;

        return view('statements.index', compact('statements','title','send_statement'));
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
    public function update(Request $request, Statement $statement)
    {
        //
    }

    /**
     * Toggle a statement as being paid or unpaid.
     * 
     * @param  \App\Repositories\EloquentStatementsRepository $id
     * @return Illuminate\Http\Response
     */
    public function togglePaid($id)
    {
        $this->statements->togglePaid($id);
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
        $this->statements->send($request->statement_id);
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
    public function destroy(Statement $statement)
    {
        //
    }
}
