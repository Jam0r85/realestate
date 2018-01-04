<?php

namespace App\Http\Controllers;

use App\Events\ExpenseWasCreated;
use App\Http\Requests\ExpenseDeleteRequest;
use App\Http\Requests\ExpenseStoreRequest;
use App\Http\Requests\ExpenseUpdateRequest;
use Illuminate\Http\Request;

class ExpenseController extends BaseController
{    
    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    public $model = 'App\Expense';

    /**
     * Display a listing of expenses.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->all()) {
            $request->request->add(['paid' => false]);
        }

        $expenses = $this->repository
            ->with('contractor','property','documents','statements','payments')
            ->filter($request->all())
            ->latest()
            ->paginateFilter();
            
        return view('expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new expense.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expenses.create');
    }

    /**
     * Store a newly created expense in storage.
     *
     * @param  \App\Http\Requests\ExpenseStoreRequest  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(ExpenseStoreRequest $request)
    {
        $data = $request->input();

        // Set the balance to the same amount as the cost
        $data['balance'] = $data['cost'];

        $expense = $this->repository
            ->fill($data)
            ->setData($data)
            ->save();

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $this->repository->storeDocument($file);
            }
        }

        event(new ExpenseWasCreated($expense));

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $show
     * @return \Illuminate\Http\Response
     */
    public function show($id, $show = 'index')
    {
        $expense = $this->repository
            ->findOrFail($id);

        return view('expenses.show', compact('expense','show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense = $this->repository
            ->findOrFail($id);

        return view('expenses.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ExpenseUpdateRequest $request
     * @param  int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update(ExpenseUpdateRequest $request, $id)
    {
        $expense = $this->repository
            ->findOrFail($id);

        $expense
            ->fill($request->input())
            ->save();

        $expense
            ->updateBalances();

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
        parent::destroy($request, $id);
        return redirect()->route($this->indexView);
    }
}