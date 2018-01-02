<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('getBranch')) {
	function getBranch($model = null) {

		// Check whether the given model has a branch.
		if ($model && method_exists($model, 'branch')) {
			return $model->branch();
		}

		// Check whether the user is logged in and if they have a branch.
		if (Auth::check() && Auth::user()->branch) {
			return Auth::user()->branch;
		}

		return null;
	}
}