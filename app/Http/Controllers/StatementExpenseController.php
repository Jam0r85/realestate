<?php

namespace App\Http\Controllers;

use App\Events\ExpenseWasAttachedToStatement;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(AttachExpenseToStatementRequest $request, $id)
    {
        $statement = Statement::withTrashed()->findOrFail($id);
        
    	$statement->expenses()->attach($request->expense_id, ['amount' => $request->amount]);

        flash_message('Expense #' . $request->expense_id . ' attached to Statement #' . $request->statement_id . ' with the amount ' . currency($request->amount));

        event (new ExpenseWasAttachedToStatement($statement));

    	return back();
    }
}
