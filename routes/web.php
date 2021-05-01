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
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('types', 'TypeController')->middleware('auth');

Route::resource('accounts', 'AccountController')->middleware('auth');

Route::resource('entries', 'EntryController')->middleware('auth');

Route::resource('transactions', 'TransactionController')->middleware('auth');

Route::resource('clienttypes', 'ClientTypeController')->middleware('auth');

Route::resource('clients', 'ClientController')->middleware('auth');

Route::resource('invoices', 'InvoiceController')->middleware('auth');

Route::resource('invoiceentries', 'InvoiceEntryController')->middleware('auth');

Route::resource('receipts', 'ReceiptController')->middleware('auth');

Route::resource('payments', 'PaymentController')->middleware('auth');

Route::resource('posts', 'PostController')->middleware('auth');

Route::get('/downloadPDF/{id}', 'InvoiceController@downloadPDF')->middleware('auth');

Route::get('/unpaid', 'InvoiceController@unpaid')->middleware('auth');

Route::get('/findInvoices/{id}', 'ReceiptController@findInvoices')->middleware('auth');

Route::get('/getLedger', 'AccountController@getLedger')->middleware('auth');

Route::get('export', 'EntryController@export')->middleware('auth');

Route::get('/getLedger2/{id}', 'AccountController@getLedger2')->middleware('auth');

Route::get('/getReceipts', 'ReceiptController@getReceipts')->middleware('auth');

Route::get('/getPayments', 'PaymentController@getPayments')->middleware('auth');

Route::get('/getPaymentsn', 'PaymentController@getPaymentsn')->middleware('auth');

Route::get('/envelop/{id}', 'ClientController@envelop')->middleware('auth');

Route::get('/getTrial', 'EntryController@getTrial')->middleware('auth');

Route::get('/clientBal', 'EntryController@clientBal')->middleware('auth');

Route::get('/getLed', 'EntryController@getLed')->middleware('auth');

Route::get('/getPV/{id}', 'PaymentController@getPV')->middleware('auth');

Route::get('/getUPV/{id}', 'PostController@getUPV')->middleware('auth');

Route::get('/postPV/{id}', 'PaymentController@postPV')->middleware('auth');

Route::get('/getReceiptsRange', 'ReceiptController@getReceiptsRange')->middleware('auth');

Route::get('/getPaymentsRange', 'PaymentController@getPaymentsRange')->middleware('auth');
