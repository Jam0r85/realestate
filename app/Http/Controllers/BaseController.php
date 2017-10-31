<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class BaseController extends Controller
{
	/**
	 * Flash a success message to the screen.
	 * 
	 * @param string $message
	 * @return void
	 */
	protected function successMessage($message)
	{
		flashy()->success($message);
	}

	/**
	 * Flash a warning message to the screen.
	 * 
	 * @param string $message
	 * @return void
	 */
	protected function errorMessage($message)
	{
		flashy()->error($message);
	}
}