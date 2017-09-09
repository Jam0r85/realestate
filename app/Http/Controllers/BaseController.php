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
		flash($message)->success();
	}

	/**
	 * Flash a warning message to the screen.
	 * 
	 * @param string $message
	 * @return void
	 */
	protected function warningMessage($message)
	{
		flash($message)->danger();
	}
}