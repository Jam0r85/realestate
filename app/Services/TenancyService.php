<?php

namespace App\Services;

use App\Agreement;
use App\Payment;
use App\Tenancy;
use App\TenancyRent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TenancyService
{
	/**
	 * Create a new tenancy.
	 * 
	 * @param array $data
	 * @return \App\Tenancy
	 */
	public function createTenancy(array $data)
	{
		// Store the tenancy.
		$tenancy = new Tenancy();
		$tenancy->user_id = Auth::user()->id;
		$tenancy->branch_id = 1;
		$tenancy->service_id = $data['service_id'];
		$tenancy->property_id = $data['property_id'];
		$tenancy->save();

		// Attach the tenants
		$tenancy->tenants()->attach($data['users']);

		// Store the tenancy agreement.
		$agreement = Agreement::createAgreement([
			'user_id' => Auth::user()->id,
			'tenancy_id' => $tenancy->id,
			'starts_at' => Carbon::createFromFormat('Y-m-d', $data['start_date']),
			'length' => str_slug($data['length'])
		]);

		// Store the tenancy rent amount.
		$rent = TenancyRent::create([
			'user_id' => Auth::user()->id,
			'tenancy_id' => $tenancy->id,
			'amount' => $data['rent_amount'],
			'starts_at' => $agreement->starts_at
		]);

		return $tenancy;
	}

	public function createRentAmount()
	{

	}

	public function createTenancyAgreement()
	{

	}
}