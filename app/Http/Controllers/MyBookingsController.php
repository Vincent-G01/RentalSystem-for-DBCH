<?php

namespace App\Http\Controllers;

use App\Models\sport_bookings;
use Illuminate\Http\Request;
use App\Models\event_facility_bookings;
class MyBookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $filter = $request->input('filter', 'sport');

    //     if ($filter === 'sport') {
    //         $bookings = sport_bookings::where('users_id', auth()->id())->with('sports', 'halls', 'bookedCourts')->get();
    //     } else {
    //         $bookings = Event_Facility_Bookings::where('users_id', auth()->id())->with('event', 'hall', 'bookedFacilities.facility')->get();
    //     }

    //     return view('booking.my-bookings', compact('bookings', 'filter'));
    // }

    public function index()
    {
        return view('booking.my-bookings');
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
    public function show(string $id)
    {
        
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
