<?php

Auth::routes();

Horizon::auth(function ($request) {
    return true;
});

Route::get('/setup', 'SetupController@index')->name('setup');
Route::post('/setup', 'SetupController@store')->name('setup.store');

Route::middleware(['staff'])->group(function () {

	Route::get('/', 'DashboardController@index')->name('dashboard');

	Route::prefix('calendars')->group(function () {
		Route::get('/', 'CalendarController@index')->name('calendars.index');
		Route::get('create', 'CalendarController@create')->name('calendars.create');
		Route::post('/', 'CalendarController@store')->name('calendars.store');
		Route::get('{id}/iCal', 'CalendarController@iCalFeed')->name('calendars.feed');
		Route::get('{id}/{section?}', 'CalendarController@show')->name('calendars.show');
		Route::put('{id}', 'CalendarController@update')->name('calendars.update');
		Route::post('{id}/archive', 'CalendarController@archive')->name('calendars.archive');
		Route::post('{id}/restore', 'CalendarController@restore')->name('calendars.restore');
	});

	Route::prefix('events')->group(function () {
		Route::get('/', 'EventController@index')->name('events.index');
		Route::post('search', 'EventController@search')->name('events.search');
		Route::get('feed/{id}', 'EventController@feed')->name('events.feed');
		Route::post('create', 'EventController@create')->name('events.create');
		Route::post('/', 'EventController@store')->name('events.store');
		Route::post('edit', 'EventController@editByModal')->name('events.edit-modal');
		Route::get('{id}/edit', 'EventController@edit')->name('events.edit');
		Route::put('{id}', 'EventController@update')->name('events.update');
		Route::put('{id}/restore', 'EventController@restore')->name('events.restore');
		Route::delete('{id}', 'EventController@destroy')->name('events.destroy');
		Route::delete('{id}/force-destroy', 'EventController@forceDestroy')->name('events.force-destroy');
	});

	Route::prefix('invoices')->group(function () {
		Route::get('/', 'InvoiceController@index')->name('invoices.index');
		Route::get('create', 'InvoiceController@create')->name('invoices.create');
		Route::post('/', 'InvoiceController@store')->name('invoices.store');	
		Route::post('search', 'InvoiceController@search')->name('invoices.search');
		Route::post('{id}/create-item', 'InvoiceController@createItem')->name('invoices.create-item');
		Route::get('{id}/edit-item', 'InvoiceItemController@edit')->name('invoices.edit-item'); // Item ID
		Route::put('{id}/update-item', 'InvoiceItemController@update')->name('invoices.update-item'); // Item ID
		Route::post('{id}/create-payment', 'InvoicePaymentController@store')->name('invoices.create-payment');
		Route::put('{id}', 'InvoiceController@update')->name('invoices.update');
		Route::get('{id}/{section?}', 'InvoiceController@show')->name('invoices.show');
		Route::post('{id}/archive', 'InvoiceController@archive')->name('invoices.archive');
		Route::post('{id}/restore', 'InvoiceController@restore')->name('invoices.restore');
		Route::delete('{id}', 'InvoiceController@destroy')->name('invoices.destroy');
		Route::post('{id}/create-recurring', 'InvoiceRecurringController@store')->name('invoices.create-recurring');
		Route::post('{id}/clone', 'InvoiceController@clone')->name('invoices.clone');
		Route::post('{id}/send', 'InvoiceController@send')->name('invoices.send');
	});

	Route::prefix('invoice-groups')->group(function () {
		Route::get('/', 'InvoiceGroupController@index')->name('invoice-groups.index');
		Route::post('/', 'InvoiceGroupController@store')->name('invoice-groups.store');
		Route::get('create', 'InvoiceGroupController@create')->name('invoice-groups.create');
		Route::put('{group}', 'InvoiceGroupController@update')->name('invoice-groups.update');
		Route::get('{group}/{section?}', 'InvoiceGroupController@show')->name('invoice-groups.show');
	});

	Route::prefix('properties')->group(function () {
		Route::get('/', 'PropertyController@index')->name('properties.index');
		Route::get('create', 'PropertyController@create')->name('properties.create');
		Route::post('/', 'PropertyController@store')->name('properties.store');
		Route::post('search', 'PropertyController@search')->name('properties.search');
		Route::get('{id}/{section?}', 'PropertyController@show')->name('properties.show');
		Route::post('{id}/update-owners', 'PropertyController@updateOwners')->name('properties.update-owners');
		Route::put('{property}', 'PropertyController@update')->name('properties.update');
		Route::post('{id}/update-statement-settings', 'PropertyController@updateStatementSettings')->name('properties.update-statement-settings');
		Route::post('{id}/archive', 'PropertyController@archive')->name('properties.archive');
		Route::post('{id}/restore', 'PropertyController@restore')->name('properties.restore');
	});

	Route::prefix('expenses')->group(function () {
		Route::get('/', 'ExpenseController@index')->name('expenses.index');
		Route::post('search', 'ExpenseController@search')->name('expenses.search');
		Route::get('create', 'ExpenseController@create')->name('expenses.create');
		Route::post('/', 'ExpenseController@store')->name('expenses.store');
		Route::get('{id}/{section?}', 'ExpenseController@show')->name('expenses.show');
		Route::put('{id}', 'ExpenseController@update')->name('expenses.update');
		Route::delete('{id}', 'ExpenseController@destroy')->name('expenses.destroy');
	});

	Route::prefix('rent-payments')->group(function () {
		Route::get('/', 'RentPaymentController@index')->name('payments.rent');
		Route::post('search', 'RentPaymentController@search')->name('rent-payments.search');
	});

	Route::prefix('deposit-payments')->group(function () {
		Route::get('/', 'DepositPaymentController@index')->name('deposit-payments.index');
		Route::post('search', 'DepositPaymentController@search')->name('deposit-payments.search');
	});

	Route::prefix('invoice-payments')->group(function () {
		Route::get('/', 'InvoicePaymentController@index')->name('invoice-payments.index');
		Route::post('search', 'InvoicePaymentController@search')->name('invoice-payments.search');
	});

	Route::prefix('payments')->group(function () {
		Route::get('{id}/{section?}', 'PaymentController@show')->name('payments.show');
		Route::put('{payment}', 'PaymentController@update')->name('payments.update');
		Route::delete('{payment}', 'PaymentController@destroy')->name('payments.destroy');
	});

	Route::prefix('tenancies')->group(function () {
		Route::get('/', 'TenancyController@index')->name('tenancies.index');
		Route::post('search', 'TenancyController@search')->name('tenancies.search');
		Route::get('create', 'TenancyController@create')->name('tenancies.create');
		Route::post('/', 'TenancyController@store')->name('tenancies.store');
		Route::get('{id}/{section?}', 'TenancyController@show')->name('tenancies.show');
		Route::post('old-statement', 'OldStatementController@store')->name('old-statement.store');
		Route::post('{tenancy}/create-rent-payment', 'RentPaymentController@store')->name('tenancies.create-rent-payment');
		Route::post('{id}/create-rental-statement', 'TenancyController@createRentalStatement')->name('tenancies.create-rental-statement');
		Route::post('{id}/create-rent-amount', 'TenancyController@createRentAmount')->name('tenancies.create-rent-amount');
		Route::post('{id}/update-discounts', 'TenancyController@updateDiscounts')->name('tenancies.update-discounts');
		Route::post('{id}/tenants-vacated', 'TenancyController@tenantsVacated')->name('tenancies.tenants-vacated');
		Route::delete('{id}/archive', 'TenancyController@archive')->name('tenancies.archive');
	});

	Route::get('{tenancy}/rent-payments/print', 'RentPaymentController@print')->name('rent-payments.print');
	Route::get('{tenancy}/rent-payments/print-with-statements', 'RentPaymentController@printWithStatements')->name('rent-payments.print-with-statements');

	Route::resource('tenancy-rents', 'TenancyRentController');
	Route::resource('services', 'ServiceController');

	Route::prefix('statements')->group(function () {
		Route::get('/', 'StatementController@index')->name('statements.index');
		Route::post('search', 'StatementController@search')->name('statements.search');
		Route::post('/{tenancy}', 'StatementController@store')->name('statements.store');
		Route::get('{statement}/{section?}', 'StatementController@show')->name('statements.show');
		Route::post('{id}/create-invoice-item', 'StatementController@createInvoiceItem')->name('statements.create-invoice-item');
		Route::post('{id}/create-expense-item', 'StatementController@createExpenseItem')->name('statements.create-expense-item');
		Route::post('{id}/create-payments', 'StatementController@createPayments')->name('statements.create-payments');
		Route::post('{statement}/send', 'StatementController@send')->name('statements.send');
		Route::put('{statement}', 'StatementController@update')->name('statements.update');
		Route::put('{statement}/archive', 'StatementController@archive')->name('statements.archive');
		Route::put('{statement}/restore', 'StatementController@restore')->name('statements.restore');
		Route::delete('{statement}/destroy', 'StatementController@destroy')->name('statements.destroy');
	});

	Route::prefix('statement-payments')->group(function () {
		Route::get('/', 'StatementPaymentController@index')->name('statement-payments.index');
		Route::get('print', 'StatementPaymentController@print')->name('statement-payments.print');
		Route::post('/{statement}', 'StatementPaymentController@store')->name('statement-payments.store');
		Route::get('{payment}/edit', 'StatementPaymentController@edit')->name('statement-payments.edit');
		Route::put('{payment}', 'StatementPaymentController@update')->name('statement-payments.update');
		Route::delete('{payment}', 'StatementPaymentController@destroy')->name('statement-payments.destroy');
	});

	Route::prefix('users')->group(function () {
		Route::get('/', 'UserController@index')->name('users.index');
		Route::post('search', 'UserController@search')->name('users.search');
		Route::get('create', 'UserController@create')->name('users.create');
		Route::post('/', 'UserController@store')->name('users.store');
		Route::get('{id}/edit', 'UserController@edit')->name('users.edit');
		Route::get('{id}/{section?}', 'UserController@show')->name('users.show');
		Route::put('{id}/update-email', 'UserController@updateEmail')->name('users.update-email');
		Route::put('{id}/update-password', 'UserPasswordController@changePassword')->name('users.update-password');
		Route::post('{id}/send-email', 'UserController@sendEmail')->name('users.send-email');
		Route::put('{id}', 'UserController@update')->name('users.update');
		Route::post('{id}/archive', 'UserController@archive')->name('users.archive');
		Route::post('{id}/restore', 'UserController@restore')->name('users.restore');
		Route::post('{id}/send-sms', 'SmsController@toUser')->name('users.send-sms');
		Route::post('{id}/clear-notifications', 'UserController@clearNotifications')->name('users.clear-notifications');
	});

	Route::get('user-logins', 'UserLoginController@index')->name('user-logins.index');

	Route::prefix('bank-accounts')->group(function () {
		Route::get('/', 'BankAccountController@index')->name('bank-accounts.index');
		Route::get('archived', 'BankAccountController@archived')->name('bank-accounts.archived');
		Route::post('search', 'BankAccountController@search')->name('bank-accounts.search');
		Route::get('create', 'BankAccountController@create')->name('bank-accounts.create');
		Route::post('/', 'BankAccountController@store')->name('bank-accounts.store');
		Route::get('{id}/{section?}', 'BankAccountController@show')->name('bank-accounts.show');
		Route::put('{id}', 'BankAccountController@update')->name('bank-accounts.update');
		Route::delete('{id}', 'BankAccountController@destroy')->name('bank-accounts.destroy');
		Route::put('{id}/restore', 'BankAccountController@restore')->name('bank-accounts.restore');
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
		Route::post('hmrc-landlords-income', 'ReportController@landlordsIncome')->name('reports.hmrc-landlords-income');
		Route::post('landlord-tax-report', 'ReportController@landlordTaxReport')->name('reports.landlord-tax-report');
	});

	Route::prefix('settings')->group(function () {
		Route::view('/', 'settings.general')->name('settings.general');
		Route::view('invoice', 'settings.invoice')->name('settings.invoice');
		Route::view('statement', 'settings.statement-settings')->name('settings.statement');
		Route::view('logo', 'settings.logo')->name('settings.logo');
		Route::post('logo', 'SettingController@updateLogo')->name('settings.update-logo');
		Route::delete('logo', 'SettingController@destroyLogo')->name('settings.destroy-logo');
		Route::get('tax-rates', 'SettingController@taxRates')->name('settings.tax-rates');
		Route::post('tax-rates', 'SettingController@storeTaxRate')->name('settings.store-tax-rate');
		Route::get('tax-rates/{id}', 'SettingController@editTaxRate')->name('settings.edit-tax-rate');
		Route::put('tax-rates/{id}', 'SettingController@updateTaxRate')->name('settings.update-tax-rate');
		Route::delete('tax-rates/{id}', 'SettingController@destroyTaxRate')->name('settings.destroy-tax-rate');
		Route::put('tax-rates/{id}/restore', 'SettingController@restoreTaxRate')->name('settings.restore-tax-rate');
		Route::put('/', 'SettingController@update')->name('settings.update');
	});

	Route::prefix('gas-safe')->group(function () {
		Route::get('/', 'GasController@index')->name('gas-safe.index');
		Route::get('archived', 'GasController@archived')->name('gas-safe.archived');
		Route::post('/search', 'GasController@search')->name('gas-safe.search');
		Route::get('create', 'GasController@create')->name('gas-safe.create');
		Route::post('/', 'GasController@store')->name('gas-safe.store');
		Route::get('{id}/{section?}', 'GasController@show')->name('gas-safe.show');
		Route::put('{id}', 'GasController@update')->name('gas-safe.update');
		Route::delete('{id}', 'GasController@destroy')->name('gas-safe.destroy');
		Route::post('{id}/complete', 'GasController@complete')->name('gas-safe.completed');
		Route::post('{id}/send-reminder', 'GasController@sendReminder')->name('gas-safe.send-reminder');
	});

	Route::prefix('deposit')->group(function () {
		Route::get('/', 'DepositController@index')->name('deposit.index');
		Route::get('archived', 'DepositController@archived')->name('deposit.archived');
		Route::post('/search', 'DepositController@search')->name('deposit.search');
		Route::post('/', 'DepositController@store')->name('deposit.store');
		Route::put('{id}', 'DepositController@update')->name('deposit.update');
		Route::post('{id}/upload-certificate', 'DepositController@uploadCertificate')->name('deposit.upload-certificate'); 
		Route::post('{deposit}/record-payment', 'DepositPaymentController@store')->name('deposit.record-payment');
		Route::delete('{id}/delete-certificate', 'DepositController@destroyCertificate')->name('deposit.destroy-certificate');
	});

	Route::prefix('documents')->group(function () {
		Route::post('/', 'DocumentController@store')->name('documents.store');
		Route::get('{id}/{section?}', 'DocumentController@show')->name('documents.show');
		Route::put('{id}', 'DocumentController@update')->name('documents.update');
	});

	Route::get('sms', 'SmsController@index')->name('sms.index');

	Route::prefix('appearances')->group(function () {
		Route::get('/', 'AppearanceController@index')->name('appearances.index');
		Route::get('create', 'AppearanceController@create')->name('appearances.create');
		Route::post('/', 'AppearanceController@store')->name('appearances.store');
		Route::get('{appearance}/{section?}', 'AppearanceController@show')->name('appearances.show');
	});

});

Route::get('sms/delivery-status', 'SmsController@deliveryStatus');
Route::get('sms/inbound', 'SmsController@incoming');