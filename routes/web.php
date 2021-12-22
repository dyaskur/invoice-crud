<?php

use App\Http\Controllers\InvoiceController;
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

Route::get('/', function() {
    return redirect(\route('invoices.index'));
});
Route::get('/invoices/json', [App\Http\Controllers\InvoiceController::class, 'json'])->name('invoices.json');

Route::resources([
                     'invoices' => InvoiceController::class,
                 ]);

