<?php

use App\Livewire\BookingList;
use App\Livewire\sportPaymentDetail;

use Illuminate\Support\Facades\Route;
use App\Livewire\DateTimeAvailability;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\HallListController;
use App\Http\Controllers\BookingListController;
use App\Http\Controllers\EventRentalController;
use App\Http\Controllers\SportRentalController;
use App\Http\Controllers\sportPaymentController;
use App\Http\Controllers\EventFacilityPaymentController;
use App\Http\Controllers\MyBookingsController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Route::get('/halllist', [HallListController::class, 'index'])->name('halllist');


Route::resource('/halllist',HallListController::class)->names([
    'index' => 'halllist',
    'create' => 'halllist.create',
    'store' => 'halllist.store',
    'show' => 'halllist.show',
    'update' => 'halllist.update',
    'destroy' => 'halllist.delete'
]);

// Route::resource('/booking-list',BookingListController::class)->names([
//     'index' => 'booking-list',
//     'create' => 'booking-list.create',
//     'store' => 'booking-list.store',
//     'show' => 'booking-list.show',
//     'update' => 'booking-list.update',
//     'destroy' => 'booking-list.delete'
// ]);

Route::resource('/sport-rental-list',SportRentalController::class)->names([
    'index' => 'sport-rental-list',
    'create' => 'sport-rental-list.create',
    'store' => 'sport-rental-list.store',
    'show' => 'sport-rental-list.show',
    'update' => 'sport-rental-list.update',
    'destroy' => 'sport-rental-list.delete'
]);

Route::resource('/event-rental-list',EventRentalController::class)->names([
    'index' => 'event-rental-list',
    'create' => 'event-rental-list.create',
    'store' => 'event-rental-list.store',
    'show' => 'event-rental-list.show',
    'update' => 'event-rental-list.update',
    'destroy' => 'event-rental-list.delete'
]);


// Route::resource('/booking',BookingController::class)->names([
//     'index' => 'booking',
//     'create' => 'booking.create',
//     'store' => 'booking.store',
//     'show' => 'booking.show',
//     'update' => 'booking.update',
//     'destroy' => 'booking.delete'
// ]);

// Route::resource('/payment',PaymentController::class)->names([
//     'index' => 'payment',
//     'create' => 'payment.create',
//     'store' => 'payment.store',
//     'show' => 'payment.show',
//     'update' => 'payment.update',
//     'destroy' => 'payment.delete'
// ]);

// Route::resource('/create-payment-indent',PaymentController::class, )->names([
//     'index' => 'createPaymentIntent',
//     'create' => 'createPaymentIntent.create',
//     'store' => 'createPaymentIntent.store',
//     'show' => 'createPaymentIntent.show',
//     'update' => 'createPaymentIntent.update',
//     'destroy' => 'createPaymentIntent.delete'
// ]);

// Route::get('/payment', [PaymentController::class, 'showPaymentPage'])->name('payment.page');

// Route::post('/create-payment-intent', [PaymentController::class, 'createPaymentIntent'])->name('payment.intent');

// Route::resource('/sportPayment',sportPaymentController::class)->names([
//     'index' => 'sportPayment',
//     'create' => 'sportPayment.create',
//     'store' => 'sportPayment.store',
//     'show' => 'sportPayment.show',
//     'update' => 'sportPayment.update',
//     'destroy' => 'sportPayment.delete'
// ]);
// Route::get('/sport-payment/{sportPayment}', [sportPaymentController::class, 'show'])->name('sportPayment.show');
Route::get('/sport-payment/{bookingId}', [SportPaymentController::class, 'show'])->name('sportPayment.show');


Route::resource('/event-facility-payment',EventFacilityPaymentController::class)->names([
    'index' => 'event-facility-payment',
    'create' => 'event-facility-payment.create',
    'store' => 'event-facility-payment.store',
    'show' => 'event-facility-payment.show',
    'update' => 'event-facility-payment.update',
    'destroy' => 'event-facility-payment.delete'
]);

Route::get('/event-facility-payment/{bookingId}', [EventFacilityPaymentController::class, 'show'])->name('EventFacilityPayment.show');
// Route::post('/event-facility-payment', [EventFacilityPaymentController::class, 'process'])->name('EventFacilityPayment.process');



// Route::post('/stripe', [StripeController::class, 'handlePost'])->name('stripe.post');
// Route::post('/stripe')->name('stripe.post');
// Route::get('/availability', DateTimeAvailability::class)->name('date-time-availability');
// Route::get('/payment/{sportBooking}', sportPaymentDetail::class)->name('sportPayment.show');
// Route::get('/payment/details', sportPaymentDetail::class)->name('sportPayment.details');
// Route::get('/availability', DateTimeAvailability::class)->name('date-time-availability');

// Route::middleware(['auth:sanctum', 'verified'])->get('/my-bookings', MyBookingsComponent::class)->name('my-bookings');
Route::get('/my-bookings', [MyBookingsController::class, 'index'])->name('my-bookings');