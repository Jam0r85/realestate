<?php

namespace App\Http\Controllers;

use App\Events\StatementWasDeleted;
use App\Events\StatementWasSent;
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
    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    public $model = 'App\Statement';

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Show the form for creating a new resource.
     *
     * @param  \App\Http\Requests\StatementStoreRequest  $request
     * @return.\Illuminate\Http\Response
     */
    public function store(StatementStoreRequest $request)
    {
        $tenancy = Tenancy::withTrashed()
            ->findOrFail($request->tenancy_id);

        $statement = $this->repository
            ->fill($request->input());

        $tenancy->storeStatement($statement);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $show
     * @return \Illuminate\Http\Response
     */
    public function show($id, $show = 'items')
    {
        $statement = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('statements.show', compact('statement','show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $statement = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('statements.edit', compact('statement'));
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

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $statement = parent::destroy($request, $id);

        event(new StatementWasDeleted($statement));

        return redirect()->route($this->indexView);
    }

    /**
     * Send the statements to the owners.
     * 
     * @param  \App\Http\Requests\StatementSendRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function send(StatementSendRequest $request, $id)
    {
        $statement = $this->repository
            ->findOrFail($id)
            ->send();

        event(new StatementWasSent($statement));

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
}
