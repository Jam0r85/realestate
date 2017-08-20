<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Http\Requests\StoreExpenseRequest;
use App\Services\ExpenseService;
use Illuminate\Http\Request;

class ExpenseController extends BaseController
{
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
    public function show(Expense $expense)
    {
        //
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
