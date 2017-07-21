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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

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
	Route::get('unpaid', 'InvoiceController@unpaid')->name('invoices.unpaid');
	Route::get('overdue', 'InvoiceController@overdue')->name('invoices.overdue');
	Route::get('create', 'InvoiceController@create')->name('invoices.create');
	Route::post('/', 'InvoiceController@store')->name('invoices.store');	
	Route::post('search', 'InvoiceController@search')->name('invoices.search');
	Route::post('{id}/create-item', 'InvoiceController@createItem')->name('invoices.create-item');
	Route::get('{item_id}/edit-item', 'InvoiceItemController@edit')->name('invoices.edit-item');
	Route::put('{item_id}/update-item', 'InvoiceItemController@update')->name('invoices.update-item');
	Route::post('{id}/create-payment', 'InvoiceController@createPayment')->name('invoices.create-payment');
	Route::put('{id}', 'InvoiceController@update')->name('invoices.update');
	Route::get('{id}/{section?}', 'InvoiceController@show')->name('invoices.show');
	Route::post('{id}/archive', 'InvoiceController@archive')->name('invoices.archive');
});

Route::prefix('invoice-groups')->group(function () {
	Route::post('/', 'InvoiceGroupController@store')->name('invoice-groups.store');
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
});

Route::prefix('tenancies')->group(function () {
	Route::get('/', 'TenancyController@index')->name('tenancies.index');
	Route::get('with-rent-balance', 'TenancyController@withRentBalance')->name('tenancies.with-rent-balance');
	Route::post('search', 'TenancyController@search')->name('tenancies.search');
	Route::get('{id}/{section?}', 'TenancyController@show')->name('tenancies.show');
	Route::post('{id}/create-rent-payment', 'TenancyController@createRentPayment')->name('tenancies.create-rent-payment');
	Route::post('{id}/create-rental-statement', 'TenancyController@createRentalStatement')->name('tenancies.create-rental-statement');
});

Route::prefix('statements')->group(function () {
	Route::get('{id}/{section?}', 'StatementController@show')->name('statements.show');
});

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
	Route::post('{id}/send-email', 'UserController@sendEmail')->name('users.send-email');
	Route::put('{id}', 'UserController@update')->name('users.update');
	Route::post('{id}/archive', 'UserController@archive')->name('users.archive');
	Route::post('{id}/restore', 'UserController@restore')->name('users.restore');
});

Route::prefix('user-groups')->group(function () {
	Route::get('/', 'UserGroupController@index')->name('user-groups.index');
	Route::post('/', 'UserGroupController@store')->name('user-groups.store');
	Route::get('{name}', 'UserGroupController@show')->name('user-groups.show'); // We do this name so it looks nicer
	Route::get('{id}/edit', 'UserGroupController@edit')->name('user-groups.edit');
	Route::put('{id}', 'UserGroupController@update')->name('user-groups.update');
});

Route::prefix('branches')->group(function () {
	Route::post('/', 'BranchController@store')->name('branches.store');
	Route::get('{id}', 'BranchController@show')->name('branches.show');
	Route::put('{id}', 'BranchController@update')->name('branches.update');
});

Route::prefix('roles')->group(function () {
	Route::post('/', 'RoleController@store')->name('roles.store');
	Route::get('{id}', 'RoleController@show')->name('roles.show');
	Route::put('{id}', 'RoleController@update')->name('roles.update');
});

Route::get('emails', 'EmailController@index')->name('emails.index');
Route::get('emails/{id}/preview', 'EmailController@preview')->name('emails.preview');

Route::get('settings', 'SettingController@index')->name('settings.index');
Route::get('settings/branches', 'BranchController@index')->name('settings.branches');
Route::get('settings/branches/roles', 'RoleController@index')->name('settings.roles');
Route::get('settings/user-groups', 'UserGroupController@index')->name('settings.user-groups');
Route::get('settings/invoice-groups', 'InvoiceGroupController@index')->name('settings.invoice-groups');
Route::get('settings/permissions', 'SettingController@permissions')->name('settings.permissions');
Route::post('settings', 'SettingController@update')->name('settings.update');
