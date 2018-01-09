<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use Illuminate\Http\Request;

class BaseController extends Controller
{
	/**
	 * The repository for this controller.
	 */
	protected $repository;

	/**
	 * The eloquent model for this controller's repository.
	 */
	protected $model;

	/**
	 * The default path to the eloquent model.
	 */
	protected $modelPath = 'App';

	/**
	 * The search term session name for this model.
	 */
	protected $searchSessionName;

	/**
	 * The name used to send the search results to the view.
	 */
	protected $resultsName;

	/**
	 * The index route for this controller.
	 * 
	 * @var string
	 */
	protected $indexRoute;

	/**
	 * Build the controller.
	 * 
	 * @return void
	 */
	public function __construct()
	{
		$this->setRepository();
		$this->setIndexRoute();
		$this->setSearchResultsVariable();
		$this->setSearchSessionName();
	}

	/**
	 * Search through the repository.
	 * 
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function search(SearchRequest $request)
	{
		// Clear the search term from the session name
        if ($request->has('clear_search')) {
            session()->forget($this->searchSessionName);
            return redirect()->route($this->indexRoute);
        }

        // Store the search term to the session name
        session()->put($this->searchSessionName, $request->search_term);

        return view($this->indexRoute, [
        	'title' => 'Search Results',
        	$this->resultsName => $this->repository->search(session()->get($this->searchSessionName))->get()
        ]);
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
        return $this->repository
        	->findOrFail($id)
        	->delete();
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
     * @param  integer  $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function forceDestroy(Request $request, $id)
    {
        return $this->repository
        	->withTrashed()
        	->findOrFail($id)
        	->forceDelete();
	}
	
	/**
	 * Get the name to be used for the search term stored in sessions.
	 * 
	 * @return string;
	 */
	public function setSearchSessionName()
	{
		if (! $this->searchSessionName) {
			$this->searchSessionName = snake_case(model_name($this->repository)) . '_search_term';
		}
	}

	/**
	 * Set the search results variable.
	 * 
	 * @return string
	 */
	public function setSearchResultsVariable()
	{				
		$this->resultsName = str_plural(snake_case($this->repository->className()));
	}

	/**
	 * Set the repository instance.
	 * 
	 * @return void
	 */
	public function setRepository()
	{
		if (! $this->model) {
			$this->model = $this->modelPath . '\\' . str_replace('Controller', '', class_basename($this));
		}

		$this->repository = new $this->model();
	}

	/**
	 * Set the index route for this controller.
	 *
	 * @return void
	 */
	public function setIndexRoute()
	{
		if (! $this->indexRoute) {
			$this->indexRoute = plural_from_model($this->repository) . '.index';
		}
	}
}