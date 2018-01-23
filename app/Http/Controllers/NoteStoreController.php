<?php

namespace App\Http\Controllers;

use App\Maintenance;
use Illuminate\Http\Request;

class NoteStoreController extends BaseController
{
	/**
	 * The eloquent model for this controller.
	 * 
	 * @var string
	 */
	protected $model = 'App\Note';

	/**
	 * Store a note for a maintenance issue into storage.
	 * 
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
    public function maintenanceIssue(Request $request, $id)
    {
    	$issue = Maintenance::withTrashed()->findOrFail($id);

    	$issue->storeNote(
    		$this->repository->fill($request->input())
    	);

    	return back();
    }
}
