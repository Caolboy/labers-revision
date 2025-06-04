<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    // USER ROUTES
    Route::get('booking', function () {
        return Inertia::render('Booking');
    })->name('booking');

    Route::get('usercalendar', function () {
        return Inertia::render('UserCalendarView');
    })->name('usercalendar');

    Route::get('bookinghistory', function () {
        return Inertia::render('UserBookingHistory');
    })->name('bookinghistory');

    Route::get('createlab', function () {
        return Inertia::render('admin/AllLabs');
    })->name('createlab');

    // ADMIN ROUTES
    Route::middleware('admin')->group(function () {
        Route::get('dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');
        Route::get('calendar', fn () => Inertia::render('Calendar'))->name('calendar');
        Route::get('allbookings', fn () => Inertia::render('AllBookings'))->name('allbookings');
        Route::get('allusers', fn () => Inertia::render('UserManagement'))->name('allusers');
        Route::get('allrooms', fn () => Inertia::render('RoomManagement'))->name('allrooms');
        Route::get('allequipments', fn () => Inertia::render('EquipmentManagement'))->name('allequipments');
        Route::get('addequipments', fn () => Inertia::render('CreateEquipment'))->name('addequipments');
        Route::get('addrooms', fn () => Inertia::render('CreateRoom'))->name('addrooms');   
        Route::get('addusers', fn () => Inertia::render('CreateUser'))->name('addusers');     
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/api.php';