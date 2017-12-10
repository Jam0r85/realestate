<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Http\Requests\ExpenseDeleteRequest;
use App\Http\Requests\ExpenseStoreRequest;
use App\Http\Requests\ExpenseUpdateRequest;
use App\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends BaseController
{    
    /**
     * Display a listing of expenses.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $expenses = Expense::with('contractor','property','documents','statements','payments')->filter($request->all())->latest()->paginateFilter();
        return view('expenses.index', compact('expenses'));
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

        $searchResults = Expense::search(Session::get('expenses_search_term'))->get();
        $title = 'Search Results';

        return view('expenses.index', compact('searchResults', 'title'));
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
        $property = Property::findOrFail($request->property_id);

        $expense = new Expense();
        $expense->name = $request->name;
        $expense->cost = $request->cost;
        $expense->contractor_id = $request->contractor_id;
        $expense->data = ['contractor_reference' => $request->contractor_reference];

        $property->expenses()->save($expense);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $expense->storeDocument($file);
            }
        }

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
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\ExpenseUpdateRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseUpdateRequest $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->name = $request->name;
        $expense->cost = $request->cost;
        $expense->contractor_id = $request->contractor_id;
        $expense->property_id = $request->property_id;
        $expense->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Http\Requests\ExpenseDeleteRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseDeleteRequest $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();
        return redirect()->route('expenses.index');
    }
}
