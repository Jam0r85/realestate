<?php

namespace App\Http\Controllers;

use App\Document;
use App\Expense;
use App\Http\Requests\StoreExpenseRequest;
use App\Services\DocumentService;
use App\Services\ExpenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @param   EloquentUsersRepository $users
     * @return  void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of paid expenses.
     *
     * @return \Illuminate\Http\Response
     */
    public function paid()
    {
        $expenses = Expense::whereNotNull('paid_at')->latest()->paginate();
        $title = 'Paid Expenses';

        return view('expenses.paid', compact('expenses','title'));
    }

    /**
     * Display a listing of unpaid expenses.
     *
     * @return \Illuminate\Http\Response
     */
    public function unpaid()
    {
        $expenses = Expense::whereNull('paid_at')->latest()->paginate();
        $title = 'Unpaid Expenses';

        return view('expenses.unpaid', compact('expenses','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExpenseRequest $request)
    {
        $data = $request->input();
        $data['files'] = $request->file('files');

        $service = new ExpenseService();
        $service->createExpense($data);

        $this->successMessage('The expense was created');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = Expense::findOrFail($id);
        return view('expenses.show.layout', compact('expense'));
    }

    /**
     * Upload invoices to the expense.
     * 
     * @param  Request $request [description]
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function uploadInvoices(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);

        foreach ($request->file('invoices') as $invoice) {

            $service = new DocumentService();
            $document = $service->storeFile($invoice, 'expenses');
            $document['name'] = $expense->name . ' Invoice';

            $stored_invoice = $service->createDocument($document);

            $expense->invoices()->save($stored_invoice);
        }

        $this->successMessage('The invoice(s) were uploaded');

        return back();
    }

    /**
     * Delete an invoice for the expense.
     * 
     * @param  Request $request [description]
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function deleteInvoice(Request $request, $id)
    {
        $invoice = Document::findOrFail($request->invoice_id);

        Storage::delete($invoice->path);

        $invoice->delete();

        $this->successMessage('The invoice was deleted');

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        //
    }
}
