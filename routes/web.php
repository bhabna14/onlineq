<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['login_auth']], function() {

    /* ========== Booking Routes ========== */
    Route::controller(BookingController::class)->group(function () {
        Route::get('/booking','index')->name('booking');
        Route::get('/booking/special','specialBooking')->name('booking.special');
        Route::post('/booking/store','store')->name('booking.store');
        Route::post('/booking/store-darshan','storeBooking')->name('booking.store-darshan');
        Route::get('/available/slot/get','getAvailableSlot')->name('available.slot');
        Route::get('/booking/payment','payment')->name('booking.payment');
        // Route::get('booking/history/view', function () {
        //     return view('booking-status-new');
        // })->name('bStatus');
        // Route::get('/booking/pdf','pdf')->name('booking.pdf');
    });


    /* ========== Dashboard Route ========== */
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard','index')->name('dashboard');
        Route::get('/dashboard/history/view/{id}','viewHistory')->name('dashboard.history.view');
    });
});

Route::controller(BookingController::class)->group(function () {
    Route::get('/booking/pdf','pdf')->name('booking.pdf');
    Route::post('/booking/cancel','cancelBooking')->name('booking.cancel');
});

Route::controller(LoginController::class)->group(function () {

    /* ========== Login Routes ========== */
    Route::get('/login','login')->name('login');
    Route::post('otp/generate','otpGenerate')->name('otp.generate');
    Route::post('otp/verify','otpVerify')->name('otp.verify');

    /* ========== Logout Route ========== */
    Route::get('/logout','logout')->name('logout');

});

/* ========== Registration Routes ========== */
Route::controller(RegistrationController::class)->group(function () {
    Route::get('/darshan-guidelines','guidelines')->name('guidelines');
    Route::get('/register','index')->name('register');
    Route::post('/register/store','store')->name('register.store');
});

/* ========== Language Routes ========== */
Route::controller(LanguageController::class)->group(function () {
    Route::get('/language/set/{lang_locale}','setLang')->name('lang.set');
});

// new booking status
// Route::get('booking-status-new', function () {
//     return view('booking-status-new');
// })->name('bStatus');

Route::get('/', function () {
    return view('home');
})->name('home');

// Route::get('payment-summary', function () {
//     return view('payment-summary');
// })->name('paymentSummary');

/*
|--------------------------------------------------------------------------
| Web Routes For Admin
|--------------------------------------------------------------------------
*/

require __DIR__ . '/admin.php';
