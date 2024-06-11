<?php

use App\Http\Controllers\Admin\BlockedDateController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes For Admin
|--------------------------------------------------------------------------
*/

Route::name('admin.')->prefix('/admin')->group(function () {

    /* ========== Login Routes ========== */
    Route::controller(LoginController::class)->group(function () {

        /* ========== Admin Login Routes ========== */
        Route::get('/','login')->name('login');
        Route::post('/login','loginPost')->name('login.post');

        /* ========== Logout Route ========== */
        Route::get('/logout','logout')->name('logout');

    });

    Route::group(['middleware' => ['admin_login_auth']], function() {

        /* ========== Dashboard Route ========== */
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/dashboard','index')->name('dashboard');
        });

        /* ========== Bookings Route ========== */
        Route::controller(BookingController::class)->group(function () {
            Route::get('/bookings','index')->name('bookings');
            Route::get('/bookings/view/{id}','view')->name('bookings.view');
            Route::post('/bookings/search','searchBooking')->name('bookings.search');
        });

        /* ========== Blocked Bookings Route ========== */
        Route::controller(BlockedDateController::class)->group(function () {
            Route::get('/bookings/blocked','index')->name('bookings.blocked');
            Route::post('/bookings/blocked/create','create')->name('bookings.blocked.create');
            Route::post('/bookings/blocked/update','update')->name('bookings.blocked.update');
            Route::post('/bookings/blocked/status','status')->name('bookings.blocked.status');
            Route::post('/bookings/blocked/delete','delete')->name('bookings.blocked.delete');
        });
    });
});
