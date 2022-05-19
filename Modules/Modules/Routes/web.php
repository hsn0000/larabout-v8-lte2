<?php

use Illuminate\Support\Facades\Route;
use Modules\Modules\Http\Controllers\ModulesController;

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

Route::prefix('modules')->name('modules')->middleware(['restriction','allowed-domain'])->group(function() {

    Route::middleware('auth')->group(function() {
        /*
         * if authenticated
         */
        Route::get('/', [ModulesController::class,'index'])->middleware('block-page:modules,read');
        Route::get('/add', [ModulesController::class,'add'])->middleware('block-page:modules,create')->name('.add');
        Route::post('/save', [ModulesController::class,'save'])->middleware('block-page:modules,create')->name('.save');
        Route::get('/edit/{id}', [ModulesController::class,'edit'])->middleware('block-page:modules,update')->name('.edit');
        Route::post('/update', [ModulesController::class,'update'])->middleware('block-page:modules,update')->name('.update');
        Route::post('/update-order', [ModulesController::class,'update_order'])->middleware('block-page:modules,update')->name('.update-order');
        Route::post('/update-published', [ModulesController::class,'update_published'])->middleware('block-page:modules,update')->name('.update-published');
    });

    Route::middleware('guest')->group(function() {
        /*
         * if guest
         */
    });
});