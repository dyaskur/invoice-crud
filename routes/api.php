<?php

use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/invoices', function(Request $request) {
    return response()->json(['data' => Invoice::all()]);
});

Route::get('/invoices/{id}', function(Request $request, $id) {
    $invoice = Invoice::where('invoice_number', $id)
        ->with('issuer:id,name,address_1,address2', 'recipient:id,name,address_1,address2')
        ->with('items')
        ->first();
    if (!$invoice) {
        return response()->json(['data' => null, 'message' => 'Record not found'], 404);
    }

    return response()->json(['data' => $invoice, 'message' => 'Record found']);
});


