<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', 'DashboardController@index')->name('home');

Route::prefix('calendars')->group(function () {
	Route::get('/', 'CalendarController@index')->name('calendars.index');
	Route::get('create', 'CalendarController@create')->name('calendars.create');
	Route::post('/', 'CalendarController@store')->name('calendars.store');
	Route::get('{id}/{section?}', 'CalendarController@show')->name('calendars.show');
	Route::put('{id}', 'CalendarController@update')->name('calendars.update');
	Route::post('{id}/archive', 'CalendarController@archive')->name('calendars.archive');
	Route::post('{id}/restore', 'CalendarController@restore')->name('calendars.restore');
});

Route::prefix('events')->group(function () {
	Route::get('/', 'EventController@index')->name('events.index');
	Route::get('feed/{id?}', 'EventController@feed')->name('events.feed');
	Route::post('create', 'EventController@create')->name('events.create');
	Route::post('/', 'EventController@store')->name('events.store');
	Route::post('edit', 'EventController@edit')->name('events.edit');
	Route::get('{id}/edit', 'EventController@edit')->name('events.edit-link');
	Route::put('{id}', 'EventController@update')->name('events.update');
	Route::get('{id}/restore', 'EventController@restore')->name('events.restore');
	Route::delete('{id}', 'EventController@destroy')->name('events.delete');
});

Route::prefix('invoices')->group(function () {
	Route::get('/', 'InvoiceController@index')->name('invoices.index');
	Route::get('create', 'InvoiceController@create')->name('invoices.create');
	Route::post('/', 'InvoiceController@store')->name('invoices.store');	
	Route::post('search', 'InvoiceController@search')->name('invoices.search');
	Route::post('{id}/create-item', 'InvoiceController@createItem')->name('invoices.create-item');
	Route::get('{id}/edit-item', 'InvoiceItemController@edit')->name('invoices.edit-item'); // Item ID
	Route::put('{id}/update-item', 'InvoiceItemController@update')->name('invoices.update-item'); // Item ID
	Route::post('{id}/create-payment', 'InvoiceController@createPayment')->name('invoices.create-payment');
	Route::put('{id}', 'InvoiceController@update')->name('invoices.update');
	Route::get('{id}/{section?}', 'InvoiceController@show')->name('invoices.show');
	Route::post('{id}/archive', 'InvoiceController@archive')->name('invoices.archive');
	Route::delete('{id}', 'InvoiceController@destroy')->name('invoices.destroy');
});

Route::prefix('invoice-groups')->group(function () {
	Route::get('/', 'InvoiceGroupController@index')->name('invoice-groups.index');
	Route::post('/', 'InvoiceGroupController@store')->name('invoice-groups.store');
	Route::get('create', 'InvoiceGroupController@create')->name('invoice-groups.create');
	Route::get('{id}/edit', 'InvoiceGroupController@edit')->name('invoice-groups.edit');
	Route::put('{id}', 'InvoiceGroupController@update')->name('invoice-groups.update');
	Route::get('{id}', 'InvoiceGroupController@show')->name('invoice-groups.show');
});

Route::prefix('properties')->group(function () {
	Route::get('/', 'PropertyController@index')->name('properties.index');
	Route::get('create', 'PropertyController@create')->name('properties.create');
	Route::post('/', 'PropertyController@store')->name('properties.store');
	Route::post('search', 'PropertyController@search')->name('properties.search');
	Route::get('{id}/{section?}', 'PropertyController@show')->name('properties.show');
	Route::post('{id}/update-owners', 'PropertyController@updateOwners')->name('properties.update-owners');
	Route::put('{id}', 'PropertyController@update')->name('properties.update');
	Route::post('{id}/update-statement-settings', 'PropertyController@updateStatementSettings')->name('properties.update-statement-settings');
});

Route::prefix('expenses')->group(function () {
	Route::get('/', 'ExpenseController@index')->name('expenses.index');
	Route::post('search', 'ExpenseController@search')->name('expenses.search');
	Route::get('create', 'ExpenseController@create')->name('expenses.create');
	Route::get('{id}/{section?}', 'ExpenseController@show')->name('expenses.show');
	Route::put('{id}', 'ExpenseController@update')->name('expenses.update');
	Route::post('{id}/update-invoices', 'ExpenseController@updateInvoices')->name('expenses.update-invoices');
	Route::post('{id}/update-contractors', 'ExpenseController@updateContractors')->name('expenses.update-contractors');
	Route::post('/', 'ExpenseController@store')->name('expenses.store');
});

Route::prefix('payments')->group(function () {
	Route::get('rent', 'PaymentController@rentPayments')->name('payments.rent');
	Route::get('{id}/{section?}', 'PaymentController@show')->name('payments.show');
	Route::post('search', 'PaymentController@search')->name('payments.search');
	Route::put('{id}', 'PaymentController@update')->name('payments.update');
});

Route::prefix('tenancies')->group(function () {
	Route::get('/', 'TenancyController@index')->name('tenancies.index');
	Route::get('with-rent-balance', 'TenancyController@withRentBalance')->name('tenancies.with-rent-balance');
	Route::get('overdue', 'TenancyController@overdue')->name('tenancies.overdue');
	Route::post('search', 'TenancyController@search')->name('tenancies.search');
	Route::get('create', 'TenancyController@create')->name('tenancies.create');
	Route::post('/', 'TenancyController@store')->name('tenancies.store');
	Route::get('{id}/{section?}', 'TenancyController@show')->name('tenancies.show');
	Route::post('{id}/create-rent-payment', 'TenancyController@createRentPayment')->name('tenancies.create-rent-payment');
	Route::post('{id}/create-rental-statement', 'TenancyController@createRentalStatement')->name('tenancies.create-rental-statement');
	Route::post('{id}/create-old-rental-statement', 'TenancyController@createOldRentalStatement')->name('tenancies.create-old-rental-statement');
	Route::post('{id}/create-rent-amount', 'TenancyController@createRentAmount')->name('tenancies.create-rent-amount');
	Route::post('{id}/update-discounts', 'TenancyController@updateDiscounts')->name('tenancies.update-discounts');
	Route::post('{id}/tenants-vacated', 'TenancyController@tenantsVacated')->name('tenancies.tenants-vacated');
	Route::post('{id}/archive', 'TenancyController@archive')->name('tenancies.archive');
});

Route::prefix('statements')->group(function () {
	Route::get('/', 'StatementController@index')->name('statements.index');
	Route::post('search', 'StatementController@search')->name('statements.search');
	Route::get('{id}/{section?}', 'StatementController@show')->name('statements.show');
	Route::post('{id}/create-invoice-item', 'StatementController@createInvoiceItem')->name('statements.create-invoice-item');
	Route::post('{id}/create-expense-item', 'StatementController@createExpenseItem')->name('statements.create-expense-item');
	Route::post('{id}/create-payments', 'StatementController@createPayments')->name('statements.create-payments');
	Route::post('toggle-paid/{id?}', 'StatementController@togglePaid')->name('statements.toggle-paid');
	Route::post('toggle-sent/{id?}', 'StatementController@toggleSent')->name('statements.toggle-sent');
	Route::post('send', 'StatementController@send')->name('statements.send');
	Route::put('{id}', 'StatementController@update')->name('statements.update');
	Route::post('{id}/archive', 'StatementController@archive')->name('statements.archive');
	Route::post('{id}/restore', 'StatementController@restore')->name('statements.restore');
	Route::post('{id}/destroy', 'StatementController@destroy')->name('statements.destroy');
});

Route::get('statement-payments', 'StatementPaymentController@index')->name('statement-payments.index');
Route::get('statement-payments/print', 'StatementPaymentController@print')->name('statement-payments.print');
Route::post('statement-payments/mark-sent', 'StatementPaymentController@markSent')->name('statement-payments.mark-sent');

Route::prefix('users')->group(function () {
	Route::get('/', 'UserController@index')->name('users.index');
	Route::get('archived', 'UserController@archived')->name('users.archived');
	Route::post('search', 'UserController@search')->name('users.search');
	Route::get('create', 'UserController@create')->name('users.create');
	Route::post('/', 'UserController@store')->name('users.store');
	Route::get('{id}/edit', 'UserController@edit')->name('users.edit');
	Route::get('{id}/{section?}', 'UserController@show')->name('users.show');
	Route::put('{id}/update-email', 'UserController@updateEmail')->name('users.update-email');
	Route::put('{id}/update-password', 'UserController@updatePassword')->name('users.update-password');
	Route::put('{id}/update-phones', 'UserController@updatePhone')->name('users.update-phone');
	Route::put('{id}/update-groups', 'UserController@updateGroups')->name('users.update-groups');
	Route::put('{id}/update-roles', 'UserController@updateRoles')->name('users.update-roles');
	Route::put('{id}/update-home-address', 'UserController@updateHomeAddress')->name('users.update-home-address');
	Route::post('{id}/send-email', 'UserController@sendEmail')->name('users.send-email');
	Route::put('{id}', 'UserController@update')->name('users.update');
	Route::post('{id}/archive', 'UserController@archive')->name('users.archive');
	Route::post('{id}/restore', 'UserController@restore')->name('users.restore');
});

Route::prefix('bank-accounts')->group(function () {
	Route::get('/', 'BankAccountController@index')->name('bank-accounts.index');
	Route::post('search', 'BankAccountController@search')->name('bank-accounts.search');
	Route::get('create', 'BankAccountController@create')->name('bank-accounts.create');
	Route::post('/', 'BankAccountController@store')->name('bank-accounts.store');
	Route::get('{id}/{section?}', 'BankAccountController@show')->name('bank-accounts.show');
	Route::put('{id}', 'BankAccountController@update')->name('bank-accounts.update');
	Route::post('{id}/update-users', 'BankAccountController@updateUsers')->name('bank-accounts.update-users');
});

Route::prefix('user-groups')->group(function () {
	Route::get('/', 'UserGroupController@index')->name('user-groups.index');
	Route::post('/', 'UserGroupController@store')->name('user-groups.store');
	Route::get('{name}', 'UserGroupController@show')->name('user-groups.show');
	Route::get('{id}/edit', 'UserGroupController@edit')->name('user-groups.edit');
	Route::put('{id}', 'UserGroupController@update')->name('user-groups.update');
});

Route::prefix('branches')->group(function () {
	Route::get('/', 'BranchController@index')->name('branches.index');
	Route::get('create', 'BranchController@create')->name('branches.create');
	Route::post('/', 'BranchController@store')->name('branches.store');
	Route::get('{id}/{section?}', 'BranchController@show')->name('branches.show');
	Route::put('{id}', 'BranchController@update')->name('branches.update');
});

Route::prefix('roles')->group(function () {
	Route::post('/', 'RoleController@store')->name('roles.store');
	Route::get('{id}', 'RoleController@show')->name('roles.show');
	Route::put('{id}', 'RoleController@update')->name('roles.update');
});

Route::get('download/invoice/{id}', 'DownloadController@invoice')->name('downloads.invoice');
Route::get('download/statement/{id}', 'DownloadController@statement')->name('downloads.statement');
Route::get('download/payment/{id}', 'DownloadController@payment')->name('downloads.payment');

Route::get('emails', 'EmailController@index')->name('emails.index');
Route::get('emails/{id}/preview', 'EmailController@preview')->name('emails.preview');

Route::prefix('reports')->group(function () {
	Route::get('/', 'ReportController@index')->name('reports.index');
	Route::post('landlords-income', 'ReportController@landlordsIncome')->name('reports.landlords-income');
});

Route::get('settings/{section?}', 'SettingController@index')->name('settings.index');
Route::post('settings', 'SettingController@updateGeneral')->name('settings.update-general');

Route::prefix('gas-safe')->group(function () {
	Route::get('/', 'GasController@index')->name('gas-safe.index');
	Route::get('create', 'GasController@create')->name('gas-safe.create');
	Route::post('/', 'GasController@store')->name('gas-safe.store');
	Route::get('{id}/{section?}', 'GasController@show')->name('gas-safe.show');
	Route::put('{id}', 'GasController@update')->name('gas-safe.update');
	Route::delete('{id}', 'GasController@destroy')->name('gas-safe.destroy');
});
