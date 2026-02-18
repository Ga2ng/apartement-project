<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\UnitDateRateController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');

Route::get('/book/create', [BookingController::class, 'create'])->name('book.create');
Route::post('/book', [BookingController::class, 'store'])->name('book.store');
Route::get('/book/thank-you', [BookingController::class, 'thankYou'])->name('book.thank-you');

Route::get('/admin', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'verified']);

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/units', [UnitController::class, 'index'])->name('units.index');
    Route::get('/units/available', [UnitController::class, 'available'])->name('units.available');
    Route::resource('promos', PromoController::class)->except('show', 'destroy');
    Route::resource('date-rates', UnitDateRateController::class)->only('index', 'create', 'store', 'destroy');
    Route::resource('clients', ClientController::class)->except('show', 'destroy');
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [AdminBookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [AdminBookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/payments', [AdminBookingController::class, 'storePayment'])->name('bookings.payments.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
