<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', [
    App\Http\Controllers\ExampleController::class, 'aboutPage',
]);

Auth::routes();

Route::get('/firstlogin', function () {
    $user = Auth::User();
    if ($user->role == 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('user.dashboard');
    }
});

Route::get('/language', [App\Http\Controllers\LanguageController::class, 'changeLanguage'])->name('language');

Route::group([
    'prefix' => 'admin', //append URL
    'as' => 'admin.',
    'middleware' => ['auth', 'admin'],
], function () {
    //Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
    // Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    // Route::get('/user/create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
    Route::resource('user', 'App\Http\Controllers\UserController'); //index,create,store,edit,update,show,delete
    Route::resource('room', 'App\Http\Controllers\RoomController');
    Route::get('/booking/pdf', [App\Http\Controllers\BookingController::class, 'pdf'])->name('booking.pdf');
    Route::get('/booking/excel', [App\Http\Controllers\BookingController::class, 'excel'])->name('booking.excel');
    Route::get('/booking/show', [App\Http\Controllers\BookingController::class, 'show'])->name('booking.show');
    Route::resource('booking', 'App\Http\Controllers\BookingController');
});

Route::group([
    'prefix' => 'user', //append URL
    'as' => 'user.',
    'middleware' => ['auth'],
], function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboardUser'])->name('dashboard');
    Route::get('/room', [App\Http\Controllers\User\BookingController::class, 'index'])->name('room.index');
    Route::get('/room/{id}', [App\Http\Controllers\User\BookingController::class, 'booking'])->name('room.booking');
    Route::post('/room/{id}', [App\Http\Controllers\User\BookingController::class, 'bookingPost'])->name('room.booking.post');
    Route::get('/booking/{id}/cancel', [App\Http\Controllers\User\BookingController::class, 'bookingCancel'])->name('booking.cancel');
});
