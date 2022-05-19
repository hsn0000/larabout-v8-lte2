<?php

use Illuminate\Support\Facades\Route;
use Modules\OperatorGroup\Http\Controllers\OperatorGroupController;

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

Route::prefix('operator-group')->name('operator-group')->middleware(['restriction','allowed-domain'])->group(function() {

    Route::middleware('auth')->group(function() {
        /*
         * if authenticated
         */
        Route::any('/', [OperatorGroupController::class,'index'])->middleware('block-page:operator-group,read');
        Route::get('/add', [OperatorGroupController::class,'add'])->middleware('block-page:operator-group,create')->name('.add');
        Route::post('/save', [OperatorGroupController::class,'save'])->middleware('block-page:operator-group,create')->name('.save');
        Route::get('/edit/{id}', [OperatorGroupController::class,'edit'])->middleware('block-page:operator-group,update')->name('.edit');
        Route::post('/update', [OperatorGroupController::class,'update'])->middleware('block-page:operator-group,update')->name('.update');
        Route::get('/delete/{id}', [OperatorGroupController::class,'delete'])->middleware('block-page:operator-group,delete')->name('.delete');
    });
});