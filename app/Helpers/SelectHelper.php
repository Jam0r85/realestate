<?php

if (!function_exists('branches')) {
	function branches()
	{
		return cache()->tags('branches')->remember('branches', 60, function () {
			return \App\Branch::orderBy('name')->get();
		});		
	}
}

if (!function_exists('branchesCount')) {
	function branchesCount()
	{
		return cache()->tags('branches')->remember('branchesCount', 60, function () {
			return \App\Branch::count();
		});
	}
}

if (!function_exists('userGroups')) {
	function userGroups()
	{
		return cache()->tags('user_groups')->remember('userGroups', 60, function () {
			return \App\UserGroup::orderBy('name')->get();
		});
	}
}

if (!function_exists('userGroupsCount')) {
	function userGroupsCount()
	{
		return cache()->tags('user_groups')->remember('userGroupsCount', 60, function () {
			return \App\UserGroup::count();
		});
	}
}

if (!function_exists('branchRoles')) {
	function branchRoles()
	{
		return cache()->tags('branch_roles')->remember('branchRoles', 60, function () {
			return \App\Role::orderBy('branch_id')->orderBy('name')->get();
		});
	}
}

if (!function_exists('branchRolesCount')) {
	function branchRolesCount()
	{
		return cache()->tags('branch_roles')->remember('branchesRolesCount', 60, function () {
			return \App\Role::count();
		});
	}
}

if (!function_exists('permissions')) {
	function permissions()
	{
		return cache()->tags('permissions')->remember('permissions', 60, function () {
			return \App\Permission::orderBy('slug')->get();
		});
	}
}

if (!function_exists('invoiceGroups')) {
	function invoiceGroups()
	{
		return cache()->tags('invoice_groups')->remember('invoiceGroups', 60, function () {
			return \App\InvoiceGroup::orderBy('name')->get();
		});
	}
}

if (!function_exists('invoiceGroupsCount')) {
	function invoiceGroupsCount()
	{
		return \App\InvoiceGroup::count();
	}
}

if (!function_exists('users')) {
	function users()
	{
		return \App\User::latest()->get();
	}
}

if (!function_exists('properties')) {
	function properties()
	{
		return \App\Property::with('owners')->latest()->get();
	}
}

if (!function_exists('tax_rates')) {
	function tax_rates()
	{
		return \App\TaxRate::get();
	}
}

if (!function_exists('payment_methods')) {
	function payment_methods()
	{
		return \App\PaymentMethod::orderBy('name')->get();
	}
}

if (!function_exists('discounts')) {
	function discounts()
	{
		return \App\Discount::orderBy('name')->get();
	}
}

if (!function_exists('bank_accounts')) {
	function bank_accounts(array $user_ids = [])
	{
		$accounts = new \App\BankAccount();

		if (count($user_ids)) {
			$accounts = $accounts->whereHas('users', function ($query) use ($user_ids) {
				$query->whereIn('id', $user_ids);
			});
		}

		return $accounts->latest()->get();
	}
}

if (!function_exists('services')) {
	function services()
	{
		return \App\Service::orderBy('name')->get();
	}
}

if (!function_exists('tenancies')) {
	function tenancies()
	{
		return \App\Tenancy::with('users','property')
			->latest()
			->get();
	}
}

if (!function_exists('staff')) {
	function staff()
	{
		if (is_null(config('system.staff'))) {
			return null;
		}

		return \App\User::whereIn('id', config('system.staff'))->get();
	}
}

if (!function_exists('sections')) {
	function sections()
	{
		return \App\AppearanceSection::get();
	}
}

if (!function_exists('appearace_statuses')) {
	function appearance_statuses()
	{
		return \App\AppearanceStatus::get();
	}
}

if (!function_exists('price_qualifiers')) {
	function price_qualifiers()
	{
		return \App\AppearancePriceQualifier::get();
	}
}

if (!function_exists('tax_bands')) {
	function tax_bands()
	{
		return \App\TaxBand::get();
	}
}

if (!function_exists('reminder_types')) {
	function reminder_types($parent = null)
	{
		$types = new \App\ReminderType();		
		return $types->getByParent($parent);
	}
}

if (!function_exists('countries')) {
	function countries()
	{
		return Countries::all()->sortBy('name.common');
	}
}