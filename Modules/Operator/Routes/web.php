<?php

use Illuminate\Support\Facades\Route;
use Modules\Operator\Http\Controllers\OperatorController;

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

Route::prefix('operator')->name('operator')->middleware(['restriction','allowed-domain'])->group(function() {

    Route::middleware('auth')->group(function() {
        /*
         * if authenticated
         */
        Route::any('/', [OperatorController::class,'index'])->middleware('block-page:operator,read');
        Route::get('/add', [OperatorController::class,'add'])->middleware('block-page:operator,create')->name('.add');
        Route::post('/save', [OperatorController::class,'save'])->middleware('block-page:operator,create')->name('.save');
        Route::get('/edit/{id}', [OperatorController::class,'edit'])->middleware('block-page:operator,update')->name('.edit');
        Route::post('/update', [OperatorController::class,'update'])->middleware('block-page:operator,update')->name('.update');
        Route::get('/delete/{id}', [OperatorController::class,'delete'])->middleware('block-page:operator,delete')->name('.delete');
        Route::post('/update-active', [OperatorController::class,'update_active'])->middleware('block-page:operator,update')->name('.update-active');
    });
});