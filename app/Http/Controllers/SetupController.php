<?php

namespace App\Http\Controllers;

use App\Branch;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetupController extends BaseController
{
	/**
	 * The name of the route to return to.
	 * 
	 * @var string
	 */
	protected $return_route = 'dashboard';

	/**
	 * Check whether this controller can be accessed.
	 * 
	 * @return \Illuminate\Http\Response
	 */
	private function checkWhetherAllowed()
	{
		if (count(User::all())) {
			abort('403', 'Setup has already been run, this action is not allowed.');
		}
	}

	/**
	 * Show the setup page.
	 * 
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$this->checkWhetherAllowed();

		return view('setup.index');
	}

	/**
	 * Store the user and settings from the setup page.
	 * 
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->checkWhetherAllowed();

		DB::table('settings')->insert([
			['key' => 'company_name', 'value' => $request->company_name],
			['key' => 'default_country', 'value' => $request->default_country],
			['key' => 'public_url', 'value' => $request->public_url],
			['default_tax_rate_id', 'value' => 0],
			['key' => 'vat_number', 'value' => $request->vat_number]
		]);

		$branch = new Branch();
		$branch->name = $request->branch_name;
		$branch->email = $request->branch_email;
		$branch->phone_number = $request->branch_phone_number;
		$branch->save();

		$user_settings = [
			'site_admin' => true
		];

		$user = new User();
		$user->user_id = 1;
		$user->first_name = $request->first_name;
		$user->last_name = $request->last_name;
		$user->email = $request->email;
		$user->password = bcrypt($request->password);
		$user->branch_id = $branch->id;
		$user->settings = $user_settings;
		$user->save();

		$this->successMessage('The user and application have been setup. Please proceed to login');

		return redirect()->route($this->return_route);
	}
}
