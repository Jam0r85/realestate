<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use Illuminate\Http\Request;

class BaseController extends Controller
{
	/**
	 * The model that this controler deals with.
	 */
	protected $repository;

	/**
	 * The model name for the Eloquent Model.
	 */
	public $model = null;

	/**
	 * The session name for this model (used for searching)
	 */
	public $searchSessionName = null;

	/**
	 * The string name which we use to send the results to the view.
	 */
	public $resultsName = null;

	/**
	 * The index view
	 */
	public $indexView = null;

	/**
	 * Build the controller instance.
	 * 
	 * @return void
	 */
	public function __construct()
	{
		$this->repository = new $this->model();
		$this->searchSessionName = snake_case($this->repository->className()) . '_search_term';
		$this->resultsName = str_plural(snake_case($this->repository->className()));

		if (!$this->indexView) {
			$this->indexView = $this->repository->classViewName() . '.index';
		}
	}

	/**
	 * Search through the repository.
	 * 
	 * @param  \Illuminate\Http\Request  $request
	 * @return  \Illuminate\Http\Response
	 */
	public function search(SearchRequest $request)
	{
		// Clear the search term from the session name
        if ($request->has('clear_search')) {
            session()->forget($this->searchSessionName);
            return redirect()->route($this->indexView);
        }

        // Store the search term to the session name
        session()->put($this->searchSessionName, $request->search_term);

        // Set the page title in the data
        $data['title'] = 'Search Results';

        // Include the results in the data
        $data[$this->resultsName] = $this->repository->search(session()->get($this->searchSessionName))->get();

        return view($this->indexView, $data);
	}

	/**
     * Remove the specified resource from storage.
	 * 
	 * @param  \Illuminate\Http\Request  $request
	 * @param  integer  $id
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function destroy(Request $request, $id)
	{
        return $this->repository->findOrFail($id)->delete();
	}

	/**
	 * Restore a record in storage.
	 * 
	 * @param  \Illuminate\Http\Request  $request
	 * @param  integer  $id
	 * @return  \Illuminate\Http\Response 
	 */
	public function restore(Request $request, $id)
	{
        $record = $this->repository
        	->onlyTrashed()
        	->findOrFail($id)
        	->restore();

        return back();
	}

    /**
     * Destroy a record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer $id
     * @return  \Illuminate\Http\Response
     */
    public function forceDestroy(Request $request, $id)
    {
        $record = $this->repository
        	->onlyTrashed()
        	->findOrFail($id)
        	->forceDelete();

        return redirect()->route($this->indexView);
    }
}