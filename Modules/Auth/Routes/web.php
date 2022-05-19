<?php
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;

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

Route::prefix('auth')->name('auth.')->group(function() {

    Route::middleware('auth')->group(function() {
        /*
         * if authenticated
         */
        Route::get('/logout', [AuthController::class,'logout'])->name('logout');
    });

    Route::middleware('guest')->group(function() {
        /*
         * if guest
         */
        Route::get('/login', [AuthController::class,'login'])->name('login');
    });

    /*
     * for refresh captcha
     */
    Route::get('/refresh-captcha/{config?}', function (\Mews\Captcha\Captcha $captcha, $config = 'default') {
        return $captcha->src($config);
    })->name('refresh_captcha');
});
