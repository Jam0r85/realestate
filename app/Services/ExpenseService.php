<?php

namespace App\Services;

use App\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExpenseService
{
	/**
	 * Create and store a new expense.
	 * 
	 * @param array $data
	 * @return \App\Expense
	 */
	public function createExpense(array $data)
	{
		$expense = new Expense();
		$expense->user_id = Auth::user()->id;
		$expense->fill($data);
		$expense->save();

		// Do we have any contractors to attach?
		if (isset($data['contractors'])) {
			$expense->contractors()->attach($data['contractors']);
		}

		return $expense;
	}

	/**
	 * Upload an expense dcocument.
	 * 
	 * @param  [type]  $file    [description]
	 * @param  Expense $expense [description]
	 * @return [type]           [description]
	 */
	public function uploadDocument($file, Expense $expense)
    {
        $path = Storage::putFile('documents/expenses/' . $expense->id, $file);

        $extension = $file->getClientOriginalExtension();
        
        $data = [
            'name' => $expense->name . ' Invoice',
            'description' => 'Invoice for the expense ' . $expense->name,
            'path' => $path,
            'extension' => $extension,
        ];

        $document = new Document();
        $document->fill($data);
        $document->unique = str_random(30);

        return $expense->documents()->save($document);
    }
}