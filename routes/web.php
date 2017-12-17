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
		Route::post('search', 'EventController@search')->name('events.search'); // Search through the events
		Route::get('feed/{id}', 'EventController@feed')->name('events.feed'); // Get the event feed for the fullCalendar
		Route::post('create', 'EventController@create')->name('events.create'); // Show the modal to create a new event
		Route::post('/', 'EventController@store')->name('events.store'); // Store the event
		Route::post('edit', 'EventController@editByModal')->name('events.edit-modal'); // Show the modal to edit the event
		Route::get('{id}/edit', 'EventController@edit')->name('events.edit'); // Show the edit event page
		Route::put('{id}', 'EventController@update')->name('events.update'); // Update the event
		Route::delete('{id}', 'EventController@destroy')->name('events.destroy'); // Delete the event
		Route::put('{id}/restore', 'EventController@restore')->name('events.restore'); // Restore the event
		Route::delete('{id}/force-destroy', 'EventController@forceDestroy')->name('events.force-destroy'); // Destroy the event
	});

	Route::prefix('invoices')->group(function () {
		Route::get('/', 'InvoiceController@index')->name('invoices.index');
		Route::get('create', 'InvoiceController@create')->name('invoices.create');
		Route::post('/', 'InvoiceController@store')->name('invoices.store');	
		Route::post('search', 'InvoiceController@search')->name('invoices.search');
		Route::post('{id}/create-payment', 'InvoicePaymentController@store')->name('invoices.create-payment');
		Route::put('{id}', 'InvoiceController@update')->name('invoices.update');
		Route::get('{id}/edit', 'InvoiceController@edit')->name('invoices.edit');
		Route::get('{id}/{section?}', 'InvoiceController@show')->name('invoices.show');
		Route::post('{id}/create-recurring', 'InvoiceRecurringController@store')->name('invoices.create-recurring');
		Route::post('{id}/clone', 'InvoiceController@clone')->name('invoices.clone');
		Route::post('{id}/send', 'InvoiceController@send')->name('invoices.send');
		Route::put('{id}/restore', 'InvoiceController@restore')->name('invoices.restore');
		Route::delete('{id}', 'InvoiceController@destroy')->name('invoices.destroy');
		Route::put('{id}/destroy', 'InvoiceController@forceDestroy')->name('invoices.forceDestroy');
	});

	Route::prefix('invoice-items')->group(function () {
		Route::post('/', 'InvoiceItemController@store')->name('invoice-items.store'); // Store a new invoice item
		Route::get('{id}/edit', 'InvoiceItemController@edit')->name('invoice-items.edit'); // Edit an invoice item
		Route::put('{id}', 'InvoiceItemController@update')->name('invoice-items.update'); // Update an invoice item
		Route::delete('{id}', 'InvoiceItemController@destroy')->name('invoice-items.destroy'); // Destroy an invoice item
	});

	Route::prefix('invoice-groups')->group(function () {
		Route::get('/', 'InvoiceGroupController@index')->name('invoice-groups.index');
		Route::get('create', 'InvoiceGroupController@create')->name('invoice-groups.create'); // Create a new invoice group
		Route::post('/', 'InvoiceGroupController@store')->name('invoice-groups.store'); // Store a new invoice group
		Route::put('{id}', 'InvoiceGroupController@update')->name('invoice-groups.update'); // Update the invoice group
		Route::get('{id}/edit', 'InvoiceGroupController@edit')->name('invoice-groups.edit'); // Edit the invoice group
		Route::get('{id}/{section?}', 'InvoiceGroupController@show')->name('invoice-groups.show'); // Show the invoice group
	});

	Route::prefix('properties')->group(function () {
		Route::get('/', 'PropertyController@index')->name('properties.index');
		Route::post('search', 'PropertyController@search')->name('properties.search'); // Search properties
		Route::get('create', 'PropertyController@create')->name('properties.create'); // Create a new property
		Route::post('/', 'PropertyController@store')->name('properties.store'); // Store the new property
		Route::get('{id}/edit', 'PropertyController@edit')->name('properties.edit'); // Edit the property
		Route::get('{id}/{show?}', 'PropertyController@show')->name('properties.show'); // Show the property
		Route::put('{id}', 'PropertyController@update')->name('properties.update'); // Update the property
		Route::delete('{id}', 'PropertyController@destroy')->name('properties.destroy'); // Delete the property
		Route::put('{id}/restore', 'PropertyController@restore')->name('properties.restore'); // Restore the property
	});

	Route::prefix('expenses')->group(function () {
		Route::get('/', 'ExpenseController@index')->name('expenses.index');
		Route::post('search', 'ExpenseController@search')->name('expenses.search');
		Route::get('create', 'ExpenseController@create')->name('expenses.create');
		Route::post('/', 'ExpenseController@store')->name('expenses.store');
		Route::get('{id}/edit', 'ExpenseController@edit')->name('expenses.edit');
		Route::get('{id}/{section?}', 'ExpenseController@show')->name('expenses.show');
		Route::put('{id}', 'ExpenseController@update')->name('expenses.update');
		Route::delete('{id}', 'ExpenseController@destroy')->name('expenses.destroy');
	});

	Route::prefix('payments')->group(function () {
		Route::get('/', 'PaymentController@index')->name('payments.index');
		Route::post('search', 'PaymentController@search')->name('payments.search'); // Search the payments
		Route::get('{id}/edit', 'PaymentController@edit')->name('payments.edit'); // Edit the payment
		Route::get('{id}', 'PaymentController@show')->name('payments.show'); // Show the payment
		Route::put('{id}', 'PaymentController@update')->name('payments.update'); // Update the payment
		Route::delete('{payment}', 'PaymentController@destroy')->name('payments.destroy'); // Destroy the payment
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
		Route::get('{id}/{section?}', 'StatementController@show')->name('statements.show');
		Route::post('{id}/create-expense-item', 'StatementController@createExpenseItem')->name('statements.create-expense-item');
		Route::post('{id}/create-payments', 'StatementController@createPayments')->name('statements.create-payments');
		Route::post('{id}/send', 'StatementController@send')->name('statements.send');
		Route::put('{id}', 'StatementController@update')->name('statements.update');
		Route::delete('{id}/archive', 'StatementController@destroy')->name('statements.destroy');
		Route::put('{id}/restore', 'StatementController@restore')->name('statements.restore');
		Route::delete('{id}/destroy', 'StatementController@forceDestroy')->name('statements.forceDestroy');
	});

	Route::prefix('statement-payments')->group(function () {
		Route::get('/', 'StatementPaymentController@index')->name('statement-payments.index');
		Route::get('print', 'StatementPaymentController@print')->name('statement-payments.print'); // Printable view of statement payments
		Route::post('/{statement}', 'StatementPaymentController@store')->name('statement-payments.store'); // Create a statement payment
		Route::get('{payment}/edit', 'StatementPaymentController@edit')->name('statement-payments.edit'); // Edit a statement payment
		Route::put('{payment}', 'StatementPaymentController@update')->name('statement-payments.update'); // Update a statement payment
		Route::put('{payment}/send', 'StatementPaymentController@send')->name('statement-payments.send'); // Send a statement payment
		Route::delete('{payment}', 'StatementPaymentController@destroy')->name('statement-payments.destroy'); // Delete a statement payment
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
		Route::post('search', 'BankAccountController@search')->name('bank-accounts.search'); // Search the bank accounts
		Route::get('create', 'BankAccountController@create')->name('bank-accounts.create'); // Create a new bank account
		Route::post('/', 'BankAccountController@store')->name('bank-accounts.store'); // Store the new bank account
		Route::get('{id}/edit', 'BankAccountController@edit')->name('bank-accounts.edit'); // Edit the bank account
		Route::get('{id}/{section?}', 'BankAccountController@show')->name('bank-accounts.show'); // Show the bank account
		Route::put('{id}', 'BankAccountController@update')->name('bank-accounts.update'); // Update the bank account
		Route::delete('{id}', 'BankAccountController@destroy')->name('bank-accounts.destroy'); // Delete a bank account
		Route::put('{id}/restore', 'BankAccountController@restore')->name('bank-accounts.restore'); // Restore a bank account
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
		Route::get('/{show?}', 'SettingController@index')->name('settings.index');
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
		Route::get('{id}/edit', 'DocumentController@edit')->name('documents.edit');
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