<?php

namespace App\Http\Controllers;

use App\Document;
use App\Expense;
use App\Http\Requests\ExpenseStoreRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Services\DocumentService;
use App\Services\ExpenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return  void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of expenses.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unpaid_expenses = Expense::whereNull('paid_at')->latest()->get();
        $expenses = Expense::whereNotNull('paid_at')->latest()->paginate();

        $unpaid_expenses->load('property','contractors','invoices','statements');
        $expenses->load('property','contractors','invoices','statements');

        return view('expenses.index', compact('unpaid_expenses','expenses'));
    }

    /**
     * Search through the resource.
     *
     * @param \Illuminate\Http\Response $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Clear the search term.
        if ($request && $request->has('clear_search')) {
            Session::forget('expenses_search_term');
            return redirect()->route('expenses.index');
        }

        Session::put('expenses_search_term', $request->search_term);

        $expenses = Expense::search(Session::get('expenses_search_term'))->get();
        $title = 'Search Results';

        return view('expenses.index', compact('expenses', 'title'));
    }

    /**
     * Show the form for creating a new expense.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expenses.create');
    }

    /**
     * Store a newly created expense in storage.
     *
     * @param \App\Http\Requests\ExpenseStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseStoreRequest $request)
    {
        $expense = new Expense();
        $expense->user_id = Auth::user()->id;
        $expense->name = $request->name;
        $expense->property_id = $request->property_id;
        $expense->cost = $request->cost;
        $expense->contractor_id = $request->contractor_id;
        $expense->data = ['contractor_reference' => $request->contractor_reference];
        $expense->save();

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {

                $path = Storage::putFile('documents/expenses', $file);

                $invoice = new Document();
                $invoice->user_id = Auth::user()->id;
                $invoice->key = str_random(30);
                $invoice->name = $expense->name . ' Invoice';
                $invoice->path = $path;
                $invoice->extension = $file->getClientOriginalExtension();

                $expense->invoices()->save($invoice);
            }
        }

        $this->successMessage('The expense "' . $expense->name . '" was created');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show($id, $section ='layout')
    {
        $expense = Expense::findOrFail($id);
        return view('expenses.show.' . $section, compact('expense'));
    }

    /**
     * Update and upload invoices to the expense.
     * 
     * @param  Request $request [description]
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function updateInvoices(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $service = new DocumentService();

        for ($i = 0; $i < count($request->invoice_id); $i++) { 
            if (!is_null($request->invoice_delete[$i])) {                
                $service->deleteDocument($request->invoice_id[$i]);
            } else {
                $service->updateDocument([
                    'name' => $request->invoice_name[$i]
                ], $request->invoice_id[$i]);
            }
        }

        // Attach new users to the account.
        if ($request->has('new_invoices')) {
            foreach ($request->file('new_invoices') as $invoice) {

                $service = new DocumentService();
                $document = $service->storeFile($invoice, 'expenses');
                $document['name'] = $expense->name . ' Invoice';

                $stored_invoice = $service->createDocument($document);

                $expense->invoices()->save($stored_invoice);
            }
        }

        $this->successMessage('The invoice(s) were updated');

        return back();
    }


    /**
     * Update the contracrtors for the expense.
     * 
     * @param \Illuminate\Http\Request $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function updateContractors(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);

        if ($request->has('remove')) {
            $expense->contractors()->detach($request->remove);
        }

        if ($request->has('new_contractors')) {
            $expense->contractors()->attach($request->new_contractors);
        }

        $this->successMessage('The contractors were updated');

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExpenseRequest $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->fill($request->input());
        $expense->save();

        $expense->contractors()->sync($request->contractors);

        $this->successMessage('The expense was updated');

        return back();
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
