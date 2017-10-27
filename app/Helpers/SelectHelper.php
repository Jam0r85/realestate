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
		return cache()->tags('invoice_groups')->remember('invoiceGroupsCount', 60, function () {
			return \App\InvoiceGroup::count();
		});
	}
}

if (!function_exists('users')) {
	function users()
	{
		return cache()->tags('users')->remember('users', 60, function () {
			return \App\User::latest()->get();
		});
	}
}

if (!function_exists('properties')) {
	function properties()
	{
		return cache()->tags('properties')->remember('properties', 60, function () {
			return \App\Property::with('owners')->latest()->get();
		});
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
	function bank_accounts($user_ids)
	{
		return \App\BankAccount::whereHas('users', function ($query) use ($user_ids) {
			$query->whereIn('id', $user_ids);
		})->get();
	}
}

if (!function_exists('services')) {
	function services()
	{
		return \App\Service::orderBy('name')->get();
	}
}