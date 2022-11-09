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

Route::resource('types', 'TypeController')->middleware(['auth','admin']);

Route::resource('accounts', 'AccountController')->middleware(['auth','admin']);

Route::resource('entries', 'EntryController')->middleware(['auth','admin']);

Route::resource('transactions', 'TransactionController')->middleware(['auth','admin']);

Route::resource('clienttypes', 'ClientTypeController')->middleware(['auth','admin']);

Route::resource('clients', 'ClientController')->middleware('auth');

Route::resource('invoices', 'InvoiceController')->middleware('auth');

Route::resource('invoiceentries', 'InvoiceEntryController')->middleware(['auth','admin']);

Route::resource('receipts', 'ReceiptController')->middleware(['auth','admin']);

Route::resource('payments', 'PaymentController')->middleware(['auth','admin']);

Route::resource('posts', 'PostController')->middleware(['auth','admin']);

Route::get('/downloadPDF/{id}', 'InvoiceController@downloadPDF')->middleware('auth');

Route::get('/unpaid', 'InvoiceController@unpaid')->middleware(['auth','admin']);

Route::get('/findInvoices/{id}', 'ReceiptController@findInvoices')->middleware(['auth','admin']);

Route::get('/getLedger', 'AccountController@getLedger')->middleware(['auth','admin']);

Route::get('export', 'EntryController@export')->middleware(['auth','admin']);

Route::get('/getLedger2/{id}', 'AccountController@getLedger2')->middleware(['auth','admin']);

Route::get('/getReceipts', 'ReceiptController@getReceipts')->middleware(['auth','admin']);

Route::get('/getPayments', 'PaymentController@getPayments')->middleware(['auth','admin']);

Route::get('/getPaymentsn', 'PaymentController@getPaymentsn')->middleware(['auth','admin']);

Route::get('/envelop/{id}', 'ClientController@envelop')->middleware('auth');

Route::get('/getTrial', 'EntryController@getTrial')->middleware(['auth','admin']);
Route::get('/getTriall', 'EntryController@getTriall')->middleware(['auth','admin']);
Route::get('/getTrialll', 'EntryController@getTrialll')->middleware(['auth','admin']);

Route::get('/clientBal', 'EntryController@clientBal')->middleware(['auth','admin']);

Route::get('/getLed', 'EntryController@getLed')->middleware(['auth','admin']);

Route::get('/getPV/{id}', 'PaymentController@getPV')->middleware(['auth','admin']);

Route::get('/getUPV/{id}', 'PostController@getUPV')->middleware(['auth','admin']);

Route::get('/postPV/{id}', 'PaymentController@postPV')->middleware(['auth','admin']);

Route::get('/getReceiptsRange', 'ReceiptController@getReceiptsRange')->middleware(['auth','admin']);

Route::get('/getPaymentsRange', 'PaymentController@getPaymentsRange')->middleware(['auth','admin']);

Route::get('/eraser', function () {
    return view('eraser');
})->middleware(['auth','admin']);

Route::get('/erasePayment', 'PaymentController@indexx')->middleware(['auth','admin']);

Route::get('/erasePost', 'PostController@indexx')->middleware(['auth','admin']);
