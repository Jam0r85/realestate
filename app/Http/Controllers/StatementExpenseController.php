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
     * @param  int  $statement_id
     * @return \Illuminate\Http\Response
     */
    public function store(AttachExpenseToStatementRequest $request, $statement_id)
    {
        $statement = Statement::withTrashed()->findOrFail($statement_id);
        
    	$statement->expenses()->attach($request->expense_id, [
            'amount' => pounds_to_pence($request->amount)
        ]);

        flash_message('Expense #' . $request->expense_id . ' attached to Statement #' . $request->statement_id . ' with the amount ' . money_formatted(pounds_to_pence($request->amount)));

        event (new ExpenseWasAttachedToStatement($statement));

    	return back();
    }
}
