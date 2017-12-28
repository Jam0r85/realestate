<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Http\Requests\AttachExpenseToStatementRequest;
use App\Statement;
use Illuminate\Http\Request;

class StatementExpenseController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AttachExpenseToStatementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttachExpenseToStatementRequest $request)
    {
    	$statement = Statement::withTrashed()->findOrFail($request->statement_id);
    	$statement->expenses()->attach($request->expense_id, ['amount' => $request->amount]);

        flash_message('Expense #' . $request->expense_id . ' attached to Statement #' . $request->statement_id . ' with the amount ' . currency($request->amount));

    	return back();
    }
}
