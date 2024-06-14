<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventFacilityPaymentController extends Controller
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
    $rentalDetails = session('rentalDetails');
    if (!$rentalDetails || !isset($rentalDetails['eventId'])) {
        return redirect()->route('event-rental-list')->withErrors('Rental details not found or invalid.');
    }

    $user = Auth::user();
    $event = Events::find($rentalDetails['eventId']);

    return view('payment.event-facility-payment', [
        'user' => $user,
        'bookingId' => $bookingId,
        'rentalDetails' => $rentalDetails,
        'event' => $event,
    ]);
}


    public function process(Request $request)
    {
        // // Dummy payment processing
        // session()->flash('message', 'Payment successful!');
        // return redirect()->route('event-facility-payment');
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
