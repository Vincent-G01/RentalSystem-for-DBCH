<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Halls;
use Illuminate\Http\Request;
use App\Models\booked_courts;
use App\Models\sport_bookings;
use Illuminate\Support\Facades\Log;

class sportPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($bookingId)
{
    Log::info('Entered SportPaymentController@show', ['id' => $bookingId]);

    $sportBooking = Sport_Bookings::find($bookingId);
    if (!$sportBooking) {
        abort(404, 'Booking not found');
    }

    $user = User::find($sportBooking->users_id);
    if (!$user) {
        abort(404, 'User not found');
    }

    $hall = Halls::find($sportBooking->halls_id);
    if (!$hall) {
        abort(404, 'Hall not found');
    }

    $rentalDetails = [
        'booking_id' => $sportBooking->id,
        'date' => $sportBooking->use_date,
        'selectedTimes' => $this->getSelectedTimes($sportBooking->id),
        'totalAmount' => $sportBooking->total_amount,
        'sport_id' => $sportBooking->sports_id,
    ];

    // Store rental and user details in session for Livewire component
    session(['rentalDetails' => $rentalDetails]);
    session(['userDetails' => ['name' => $user->name, 'email' => $user->email]]);

    return view('payment.sport-payment', [
        'userName' => $user->name,
        'userEmail' => $user->email,
        'rentalDetails' => $rentalDetails,
        'hall' => $hall,
    ]);
}



private function getSelectedTimes($bookingId)
{
    $bookedCourts = Booked_Courts::where('sport_bookings_id', $bookingId)->get();
    $selectedTimes = [];
    foreach ($bookedCourts as $court) {
        $courtKey = 'Court_' . $court->court_number;
        $timeSlot = Carbon::parse($court->start_time)->format('h:ia') . ' - ' . Carbon::parse($court->end_time)->format('h:ia');
        $selectedTimes[$courtKey][] = [
            'time' => $timeSlot,
            'selected' => true,
        ];
    }
    return $selectedTimes;
}





    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
