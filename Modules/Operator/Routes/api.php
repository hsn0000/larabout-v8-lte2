<?php

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

Route::prefix('operator')->name('operator.')->middleware(['restriction','allowed-domain'])->group(function() {

    Route::middleware('auth')->group(function() {
        /*
         * if authenticated
         */
    });

    Route::middleware('guest')->group(function() {
        /*
         * if guest
         */
    });
});
