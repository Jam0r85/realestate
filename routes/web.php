<?php

Auth::routes();

Horizon::auth(function ($request) {
    return true;
});

Route::middleware(['auth'])->group(function () {

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

	// Invoices
	Route::prefix('invoices')->group(function () {
		Route::get('/', 'InvoiceController@index')->name('invoices.index');
		Route::get('create', 'InvoiceController@create')->name('invoices.create');
		Route::post('/', 'InvoiceController@store')->name('invoices.store');	
		Route::post('search', 'InvoiceController@search')->name('invoices.search');
		Route::put('{id}', 'InvoiceController@update')->name('invoices.update');
		Route::get('{id}/edit', 'InvoiceController@edit')->name('invoices.edit');
		Route::get('{id}/{section?}', 'InvoiceController@show')->name('invoices.show');
		Route::post('{id}/create-recurring', 'InvoiceRecurringController@store')->name('invoices.create-recurring');
		Route::post('{id}/clone', 'InvoiceController@clone')->name('invoices.clone');
		Route::post('{id}/send', 'InvoiceController@send')->name('invoices.send');
		Route::delete('{id}', 'InvoiceController@delete')->name('invoices.delete'); // Delete the invoice
		Route::put('{id}/restore', 'InvoiceController@restore')->name('invoices.restore'); // Restore the invoice
		Route::delete('{id}/force-delete', 'InvoiceController@forceDelete')->name('invoices.forceDelete'); // Destroy the invoice
	});

	// Invoice Item
	Route::prefix('invoice-items')->group(function () {
		Route::post('/', 'InvoiceItemController@store')->name('invoice-items.store'); // Store a new invoice item
		Route::get('{id}/edit', 'InvoiceItemController@edit')->name('invoice-items.edit'); // Edit an invoice item
		Route::put('{id}', 'InvoiceItemController@update')->name('invoice-items.update'); // Update an invoice item
		Route::delete('{id}', 'InvoiceItemController@delete')->name('invoice-items.delete'); // Delete an invoice item
	});

	// Invoice Groups
	Route::prefix('invoice-groups')->group(function () {
		Route::get('/', 'InvoiceGroupController@index')->name('invoice-groups.index');
		Route::get('create', 'InvoiceGroupController@create')->name('invoice-groups.create'); // Create a new invoice group
		Route::post('/', 'InvoiceGroupController@store')->name('invoice-groups.store'); // Store a new invoice group
		Route::put('{id}', 'InvoiceGroupController@update')->name('invoice-groups.update'); // Update the invoice group
		Route::get('{id}/edit', 'InvoiceGroupController@edit')->name('invoice-groups.edit'); // Edit the invoice group
		Route::get('{id}/{section?}', 'InvoiceGroupController@show')->name('invoice-groups.show'); // Show the invoice group
		Route::delete('{id}', 'InvoiceGroupController@delete')->name('invoice-groups.delete'); // Delete the invoice group
		Route::put('{id}/restore', 'InvoiceGroupController@restore')->name('invoice-groups.restore'); // Restore the invoice group
		Route::delete('{id}/forceDelete', 'InvoiceGroupController@forceDelete')->name('invoice-groups.forceDelete'); // Destroy the invoice group
	});

	// Properties
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
		Route::delete('{id}/forceDelete', 'PropertyController@forceDestroy')->name('properties.forceDestroy');// Destroy the property
	});

	// Expenses
	Route::prefix('expenses')->group(function () {
		Route::get('/', 'ExpenseController@index')->name('expenses.index');
		Route::post('search', 'ExpenseController@search')->name('expenses.search');
		Route::get('create', 'ExpenseController@create')->name('expenses.create'); // Create an expense
		Route::post('/', 'ExpenseController@store')->name('expenses.store'); // Store an expense
		Route::get('{id}/edit', 'ExpenseController@edit')->name('expenses.edit'); // Edit the expense
		Route::get('{id}/{show?}', 'ExpenseController@show')->name('expenses.show'); // Show the expense
		Route::put('{id}', 'ExpenseController@update')->name('expenses.update'); // Update the expense
		Route::delete('{id}', 'ExpenseController@destroy')->name('expenses.destroy'); // Destroy the expense
	});

	// Payments (App\Payments)
	Route::prefix('payments')->group(function () {
		Route::get('/', 'PaymentController@index')->name('payments.index');
		Route::post('search', 'PaymentController@search')->name('payments.search'); // Search the payments
		Route::get('{id}/edit', 'PaymentController@edit')->name('payments.edit'); // Edit the payment
		Route::get('{id}', 'PaymentController@show')->name('payments.show'); // Show the payment
		Route::put('{id}', 'PaymentController@update')->name('payments.update'); // Update the payment
		Route::delete('{id}', 'PaymentController@delete')->name('payments.delete'); // Delete the payment

		Route::post('{id}/rent-payment', 'RentPaymentController@store')->name('tenancies.create-rent-payment'); // Store a new tenancy rent payment
		Route::post('{id}/invoice', 'InvoicePaymentController@store')->name('invoices.store-payment'); // Store a new invoice payment
		Route::post('{id}/deposit', 'DepositPaymentController@store')->name('deposits.store-payment'); // Store a new deposit payment
	});

	// Tenancies
	Route::prefix('tenancies')->group(function () {
		Route::get('{id}/fix-amounts', 'StatementController@fixAmounts');

		Route::get('/', 'TenancyController@index')->name('tenancies.index');
		Route::post('search', 'TenancyController@search')->name('tenancies.search'); // Search tenancies
		Route::get('create', 'TenancyController@create')->name('tenancies.create'); // Create a new tenancy
		Route::post('/', 'TenancyController@store')->name('tenancies.store'); // Store a new tenancy
		Route::get('{id}/edit', 'TenancyController@edit')->name('tenancies.edit'); // Edit the tenancy
		Route::put('{id}', 'TenancyController@update')->name('tenancies.update'); // Update the tenancy
		Route::get('{id}/{show?}', 'TenancyController@show')->name('tenancies.show'); // Show the tenancy
		Route::delete('{id}', 'TenancyController@delete')->name('tenancies.delete'); // Delete the tenancy
		Route::put('{id}/restore', 'TenancyController@restore')->name('tenancies.restore'); // Restore the tenancy
		Route::delete('{id}/force-delete', 'TenancyController@forceDelete')->name('tenancies.force-delete'); // Force delete a tenancy
	});

	// Tenancy Rent Payments
	Route::get('{tenancy}/rent-payments/print', 'RentPaymentController@print')->name('rent-payments.print');
	Route::get('{tenancy}/rent-payments/print-with-statements', 'RentPaymentController@printWithStatements')->name('rent-payments.print-with-statements');

	// Tenancy Rent Amounts
	Route::resource('tenancy-rents', 'TenancyRentController');

	// Tenancy Services	
	Route::prefix('services')->group(function () {
		Route::get('/', 'ServiceController@index')->name('services.index');
		Route::get('create', 'ServiceController@create')->name('services.create'); // Create a new service
		Route::post('/', 'ServiceController@store')->name('services.store'); // Store the new service
		Route::get('{id}/edit', 'ServiceController@edit')->name('services.edit'); // Edit the service
		Route::put('{id}', 'ServiceController@update')->name('services.update'); // Update the service
		Route::delete('{id}', 'ServiceController@destroy')->name('services.destroy'); // Delete the service
		Route::put('{id}/restore', 'ServiceController@restore')->name('services.restore'); // Restore the service
	});

	// Old statements
	Route::prefix('statements/old')->group(function () {
		Route::get('{id}', 'OldStatementController@create')->name('old-statements.create'); // Create an old rental statement
		Route::post('{id}', 'OldStatementController@store')->name('old-statements.store'); // Store the old rental statement
	});

	// Statements
	Route::prefix('statements')->group(function () {
		Route::get('/', 'StatementController@index')->name('statements.index');
		Route::post('search', 'StatementController@search')->name('statements.search'); // Search statements
		Route::post('/', 'StatementController@store')->name('statements.store'); // Store a new statement
		Route::get('{id}/edit', 'StatementController@edit')->name('statements.edit'); // Edit the statement
		Route::get('{id}/{show?}', 'StatementController@show')->name('statements.show'); // Show the statement
		Route::post('{id}/create-payments', 'StatementController@createPayments')->name('statements.create-payments');
		Route::post('{id}/send', 'StatementController@send')->name('statements.send');
		Route::put('{id}', 'StatementController@update')->name('statements.update'); // Update the statement
		Route::delete('{id}', 'StatementController@delete')->name('statements.delete'); // Delete the statement
		Route::put('{id}/restore', 'StatementController@restore')->name('statements.restore'); // Restore the statement
		Route::delete('{id}/force-delete', 'StatementController@forceDelete')->name('statements.forceDelete'); // Destroy the statement
	});

	// Statement Expenses
	Route::prefix('statement-expenses')->group(function () {
		Route::post('/{statement_id}', 'StatementExpenseController@store')->name('statement-expense.store'); // Store an expense to the statement
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

	// Users
	Route::prefix('users')->group(function () {
		Route::get('/', 'UserController@index')->name('users.index');
		Route::post('search', 'UserController@search')->name('users.search'); // Search users
		Route::get('create', 'UserController@create')->name('users.create'); // Create a new user
		Route::post('/', 'UserController@store')->name('users.store'); // Store a new user
		Route::get('{id}/edit', 'UserController@edit')->name('users.edit'); // Edit the user
		Route::get('{id}/{section?}', 'UserController@show')->name('users.show'); // Show the user
		Route::put('{id}/update-email', 'UserEmailController@update')->name('users.update-email'); // Update the users email
		Route::put('{id}/update-password', 'UserPasswordController@changePassword')->name('users.update-password'); // Update the users password
		Route::put('{id}/update-permissions', 'UserPermissionController@update')->name('users.update-permissions'); // Update the user's permissions
		Route::put('{id}', 'UserController@update')->name('users.update'); // Update the user
		Route::post('{id}/destroy', 'UserController@archive')->name('users.destroy'); // Delete the user
		Route::post('{id}/restore', 'UserController@restore')->name('users.restore'); // Restore the user
	});

	// User logins
	Route::get('user-logins', 'UserLoginController@index')->name('user-logins.index');

	// Notifications
	Route::prefix('notifications')->group(function () {
		Route::get('{user}', 'NotificationController@user')->name('notifications.user');
		Route::post('{user}', 'NotificationController@clearNotifications')->name('notifications.clear'); // Clear notifications for the user
	});

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

	// Branches
	Route::prefix('branches')->group(function () {
		Route::get('/', 'BranchController@index')->name('branches.index');
		Route::get('create', 'BranchController@create')->name('branches.create'); // Create a new branch
		Route::post('/', 'BranchController@store')->name('branches.store'); // Store the branch
		Route::get('{id}/edit', 'BranchController@edit')->name('branches.edit'); // Edit the branch
		Route::get('{id}/{show?}', 'BranchController@show')->name('branches.show'); // Show the brance
		Route::put('{id}', 'BranchController@update')->name('branches.update'); // Update the branch
		Route::delete('{id}', 'BranchController@destroy')->name('branches.destroy'); // Delete the branch
		Route::put('{id}/restore', 'BranchController@restore')->name('branches.restore'); // Restore the branch
		Route::put('{id}/forceDestroy', 'BranchController@forceDestroy')->name('branches.forceDestroy'); // Foce delete the branch
	});

	// Permissions
	Route::prefix('permissions')->group(function () {
		Route::get('/', 'PermissionController@index')->name('permissions.index');
		Route::get('create', 'PermissionController@create')->name('permissions.create'); // Create a new permission
		Route::post('/', 'PermissionController@store')->name('permissions.store'); // Store the permission
		Route::get('{id}/edit', 'PermissionController@edit')->name('permissions.edit'); // Edit the permission
		Route::get('{id}/{show?}', 'PermissionController@show')->name('permissions.show'); // Show the permission
		Route::put('{id}', 'PermissionController@update')->name('permissions.update'); // Update the permission
	});

	Route::get('download/invoice/{id}', 'DownloadController@invoice')->name('downloads.invoice');
	Route::get('download/statement/{id}', 'DownloadController@statement')->name('downloads.statement');
	Route::get('download/payment/{id}', 'DownloadController@payment')->name('downloads.payment');
	Route::get('download/document/{id}', 'DownloadController@document')->name('downloads.document');

	// Emails
	Route::prefix('emails')->group(function () {
		Route::get('/', 'EmailController@index')->name('emails.index'); // Get the emails
		Route::get('{id}/preview', 'EmailController@preview')->name('emails.preview'); // Preview the emails
		Route::post('{id}/email', 'EmailController@sendUserEmail')->name('users.send-email'); // Send a user an email
	});

	Route::prefix('reports')->group(function () {
		Route::get('/', 'ReportController@index')->name('reports.index');
		Route::post('hmrc-landlords-income', 'ReportController@landlordsIncome')->name('reports.hmrc-landlords-income');
		Route::post('landlord-tax-report', 'ReportController@landlordTaxReport')->name('reports.landlord-tax-report');
	});

	// Application Settings
	Route::prefix('settings')->group(function () {
		Route::get('/{show?}', 'SettingController@index')->name('settings.index'); // Get the settings
		Route::post('logo', 'SettingController@uploadLogo')->name('settings.upload-logo'); // Upload a new logo
		Route::delete('logo', 'SettingController@destroyLogo')->name('settings.destroy-logo'); // Destroy the logo
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

	// Deposits
	Route::prefix('deposit')->group(function () {
		Route::get('/', 'DepositController@index')->name('deposits.index');
		Route::post('/search', 'DepositController@search')->name('deposits.search'); // Search the deposits
		Route::get('create', 'DepositController@create')->name('deposits.create'); // Create a new deposit
		Route::post('/', 'DepositController@store')->name('deposits.store'); // Store a new deposit
		Route::get('{id}/edit', 'DepositController@edit')->name('deposits.edit'); // Edit a deposit
		Route::get('{id}/{show?}', 'DepositController@show')->name('deposits.show'); // Show a deposit
		Route::put('{id}', 'DepositController@update')->name('deposits.update'); // Update a deposit
		Route::delete('{id}', 'DepositController@destroy')->name('deposits.destroy'); // Delete a deposit
		Route::put('{id}/restore', 'DepositController@restore')->name('deposits.restore'); // Restore a deposit
		Route::delete('{id}/forceDestroy', 'DepositController@forceDestroy')->name('deposits.forceDestroy'); // Force destroy a deposit
		Route::post('{id}/upload-certificate', 'DepositController@uploadCertificate')->name('deposit.upload-certificate'); 
		Route::post('{deposit}/record-payment', 'DepositPaymentController@store')->name('deposit.record-payment');
		Route::delete('{id}/delete-certificate', 'DepositController@destroyCertificate')->name('deposit.destroy-certificate');
	});

	// Documents
	Route::prefix('documents')->group(function () {
		Route::get('/', 'DocumentController@index')->name('documents.index');
		Route::post('/search', 'DocumentController@search')->name('documents.search');
		Route::post('/', 'DocumentController@store')->name('documents.store'); // Store a new document
		Route::get('{id}/edit', 'DocumentController@edit')->name('documents.edit'); // Edit the document
		Route::get('{id}/{section?}', 'DocumentController@show')->name('documents.show'); // Show the document
		Route::put('{id}', 'DocumentController@update')->name('documents.update'); // Update the document
		Route::put('{id}/upload', 'DocumentController@upload')->name('documents.upload'); // Re-Upload the file
		Route::delete('{id}', 'DocumentController@destroy')->name('documents.destroy'); // Delete the document
		Route::put('{id}/restore', 'DocumentController@restore')->name('documents.restore'); // Store the document
		Route::delete('{id}/forceDestroy', 'DocumentController@forceDestroy')->name('documents.forceDestroy'); // Force destroy a document
	});

	// SMS
	Route::prefix('sms')->group(function () {
		Route::get('/', 'SmsController@index')->name('sms.index'); // Show a list of SMS messages
		Route::post('print', 'SmsController@print')->name('sms.print'); // Print a SMS message
		Route::post('{user}', 'SmsController@toUser')->name('sms.user'); // Send a SMS to a user		
	});
	
	// Appearances
	Route::prefix('appearances')->group(function () {
		Route::get('/', 'AppearanceController@index')->name('appearances.index');
		Route::get('create', 'AppearanceController@create')->name('appearances.create');
		Route::post('/', 'AppearanceController@store')->name('appearances.store');
		Route::get('{appearance}/{section?}', 'AppearanceController@show')->name('appearances.show');
	});

	// Reminder Types
	Route::prefix('reminder-types')->group(function () {
		Route::post('/', 'ReminderTypeController@store')->name('reminder-types.store'); // Store the new reminder type
		Route::get('{id}/edit', 'ReminderTypeController@edit')->name('reminder-types.edit'); // Edit the reminder type
		Route::get('{id}/{show?}', 'ReminderTypeController@show')->name('reminder-types.show'); // Show the reminder type
		Route::put('{id}', 'ReminderTypeController@update')->name('reminder-types.update'); // Update the reminder
	});

	// Reminders
	Route::prefix('reminders')->group(function() {
		Route::post('/', 'ReminderController@store')->name('reminders.store'); // Store a new reminder
		Route::get('{id}/{show?}', 'ReminderController@show')->name('reminders.show'); // Show the reminder
	});

	// Maintenance Issues
	Route::prefix('maintenance')->group(function () {
		Route::get('/', 'MaintenanceController@index')->name('maintenances.index');
		Route::post('/search', 'MaintenanceController@search')->name('maintenances.search');
		Route::get('create', 'MaintenanceController@create')->name('maintenances.create'); // Create a new maintenance issue
		Route::post('/', 'MaintenanceController@store')->name('maintenances.store'); // Store a new maintenance issue
		Route::get('{id}/edit', 'MaintenanceController@edit')->name('maintenances.edit'); // Edit the maintenance issue
		Route::put('{id}', 'MaintenanceController@update')->name('maintenances.update'); // Update the maintenance issue
		Route::get('{id}/{show?}', 'MaintenanceController@show')->name('maintenances.show'); // Show the maintenance issue
		Route::delete('{id}', 'MaintenanceController@delete')->name('maintenances.delete'); // Delete the maintenance issue
		Route::put('{id}/restore', 'MaintenanceController@restore')->name('maintenances.restore'); // Restore the maintenance issue
		Route::delete('{id}/force-delete', 'MaintenanceController@forceDelete')->name('maintenances.force-delete'); // Force delete the maintenance issue
	});

	// Notes & Store Notes
	Route::prefix('notes')->group(function () {

		Route::post('{id}/maintenances', 'NoteStoreController@maintenanceIssue')->name('maintenances.store-note'); // Store a maintenance issue note
	});

	// Valuations
	Route::prefix('valuations')->group(function () {
		Route::get('/', 'ValuationController@index')->name('valuations.index');
	});

	// Tenancy Agreements
	Route::prefix('agreements')->group(function () {
		Route::get('/', 'AgreementController@index')->name('agreements.index');
		Route::get('search', 'AgreementController@search')->name('agreements.search');
		Route::post('/{tenancy}', 'AgreementController@store')->name('agreements.store'); // Store an agreement (tenancy_id)
		Route::get('{id}/edit', 'AgreementController@edit')->name('agreements.edit'); // Edit the agreement
		Route::put('{id}', 'AgreementController@update')->name('agreements.update'); // Update the agreements
		Route::delete('{id}', 'AgreementController@forceDestroy')->name('agreements.forceDestroy'); // Destroy the agreement
	});

	// Payment Methods
	Route::resource('payment-methods', 'PaymentMethodController');
});

// Public SMS routes for deliery updates
Route::get('sms/delivery-status', 'SmsController@deliveryStatus');
Route::get('sms/inbound', 'SmsController@incoming');