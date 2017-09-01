<?php

namespace App\Services;

use App\Document;
use App\Expense;
use App\Services\DocumentService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExpenseService
{
	/**
	 * The folder for storing the expense documents.
	 * 
	 * @var string
	 */
	public $document_path = 'expenses';

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

		// Set the created_at date.
		if (isset($data['created_at'])) {
			$expense->created_at = Carbon::createFromFormat('Y-m-d', $data['created_at']);
		}

		// Set the paid_at date.
		if (isset($data['paid_at'])) {
			$expense->paid_at = Carbon::createFromFormat('Y-m-d', $data['paid_at']);
		}

		$expense->save();

		// Do we have any contractors to attach?
		if (isset($data['contractors'])) {
			$expense->contractors()->attach($data['contractors']);
		}

		// Do we have invoices to upload for this expense?
		if (isset($data['files'])) {
			foreach ($data['files'] as $file) {

				$service = new DocumentService();
				$document = $service->storeFile($file, $this->document_path);
				$document['name'] = $expense->name . ' Invoice';

				$invoice = $service->createDocument($document);

				$expense->invoices()->save($invoice);
			}
		}

		return $expense;
    }

    protected function checkForSimilarExpense($data, )
}