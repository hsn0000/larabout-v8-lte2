<?php
use Modules\Home\Http\Controllers\HomeController;

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

Route::name('home.')->middleware(['restriction','allowed-domain'])->group(function() {
    Route::middleware('auth')->group(function() {
        /*
         * if authenticated
         */
        Route::get('/',[HomeController::class,'index'])->middleware('block-page:dashboard,read')->name('dashboard');
    });
});
