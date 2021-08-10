<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Auth::routes();
//Auth::routes(['register' => false]);  stop register
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('invoices', 'InvoicesController' );
// sections - اضافة قسم
Route::resource('sections', 'SectionsController' );
// products - اضافة منج
Route::resource('products', 'ProductsController' );
Route::get('edit/{product_id}', 'ProductsController@update')->name('product.edit');
Route::post('products.update/{product_id}', 'ProductsController@update' )->name('products.update');
// invoices
Route::get('/section/{id}', 'InvoicesController@getproducts');
Route::get('view_file/{invoice_number}/{file_name}', 'InvoicesController@open_file');
Route::get('download_file/{invoice_number}/{file_name}', 'InvoicesController@download_file');
Route::get('status_show/{id}', 'InvoicesController@show')->name('status_show');
Route::post('status_update/{id}', 'InvoicesController@Status_Update')->name('status_update');
Route::get('invoices_paid', 'InvoicesController@invoices_paid')->name('invoices_paid');
Route::get('invoices_unpaid', 'InvoicesController@invoices_unpaid')->name('invoices_unpaid');
Route::get('invoices_partial', 'InvoicesController@invoices_partial')->name('invoices_partial');
Route::get('print_invoice/{id}', 'InvoicesController@print_invoice')->name('print_invoice');
Route::get('export_invoices', 'InvoicesController@export');
// invoices->noti
Route::get('markAsReadAll', 'InvoicesController@markAsReadAll')->name('markAsReadAll');
// Invoices-Archive
Route::resource('Archive', 'InvoicesArchive');
//Route::get('invoices_archive', 'InvoicesArchive@index')->name('invoices_archive');

// invoices Details
Route::get('/invoicesDetails/{id}', 'InvoicesDetailsController@edit')->name('invoicesDetails');
Route::post('delete-file', 'InvoicesDetailsController@destroy')->name('delete_file');

// InvoiceAttachments
Route::resource('invoice_attachments', 'InvoiceAttachmentsController' );

// spatie
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
});

// Invoices Report
Route::get('invoices_report', 'InvoicesReportController@index');
Route::post('search_invoices', 'InvoicesReportController@search_invoices');
// Customers Report
Route::get('customers_report', 'CustomersReportController@index');
Route::post('search_customers', 'CustomersReportController@search_customers');

//
Route::get('/{page}', 'AdminController@index');
