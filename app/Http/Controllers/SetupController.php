<?php

namespace App\Http\Controllers;

use App\Branch;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetupController extends BaseController
{
	public function index()
	{
		if (count(User::all())) {
			return redirect()->route('dashboard');
		}

		return view('setup.index');
	}
	
    public function store(Request $request)
    {
    	// Redirect should we already have a user account.
    	if (count(User::all())) {
    		return redirect()->route('dashboard');
    	}

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

    	$user = new User();
    	$user->first_name = $request->first_name;
    	$user->last_name = $request->last_name;
    	$user->email = $request->email;
    	$user->password = bcrypt($request->password);
    	$user->branch_id = $branch->id;
    	$user->save();

       	$this->successMessage('The user and application have been setup. Please proceed to login');

       	return redirect()->route('dashboard');
    }
}
