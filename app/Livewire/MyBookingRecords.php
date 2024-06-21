<?php

namespace App\Livewire;

use App\Models\event_facility_bookings;
use App\Models\EventFacilityBooking;
use App\Models\sport_bookings;
use App\Models\SportBooking;
use Carbon\Carbon;
use Livewire\Component;

class MyBookingRecords extends Component
{
    public $upcomingSportBookings;
    public $pastSportBookings;
    public $upcomingEventBookings;
    public $pastEventBookings;

    public function mount()
    {
        $this->loadBookings();
    }

    public function loadBookings()
    {
        $today = Carbon::today();

        $this->upcomingSportBookings = sport_bookings::where('users_id', auth()->id())
            ->where('use_date', '>=', $today)
            ->where('confirmed', true)
            ->with(['sports', 'halls', 'bookedCourts'])
            ->get()
            ->map(function ($booking) {
                $booking->formatted_date = Carbon::parse($booking->use_date)->format('d-m-Y');
                return $booking;
            });

        $this->pastSportBookings = sport_bookings::where('users_id', auth()->id())
            ->where('use_date', '<', $today)
            ->where('confirmed', true)
            ->orderBy('use_date', 'desc')
            ->with(['sports', 'halls', 'bookedCourts'])
            ->get()
            ->map(function ($booking) {
                $booking->formatted_date = Carbon::parse($booking->use_date)->format('d-m-Y');
                return $booking;
            });

        $this->upcomingEventBookings = event_facility_bookings::where('users_id', auth()->id())
            ->where('use_date', '>=', $today)
            ->where('confirmed', true)
            ->with(['events', 'halls', 'bookedFacilities.facility'])
            ->get()
            ->map(function ($booking) {
                $booking->formatted_date = Carbon::parse($booking->use_date)->format('d-m-Y');
                return $booking;
            });

        $this->pastEventBookings = event_facility_bookings::where('users_id', auth()->id())
            ->where('use_date', '<', $today)
            ->where('confirmed', true)
            ->orderBy('use_date', 'desc')
            ->with(['events', 'halls', 'bookedFacilities.facility'])
            ->get()
            ->map(function ($booking) {
                $booking->formatted_date = Carbon::parse($booking->use_date)->format('d-m-Y');
                return $booking;
            });
    }

    public function render()
    {
        return view('livewire.my-booking-records', [
            'upcomingSportBookings' => $this->upcomingSportBookings,
            'pastSportBookings' => $this->pastSportBookings,
            'upcomingEventBookings' => $this->upcomingEventBookings,
            'pastEventBookings' => $this->pastEventBookings,
        ]);
    }
}
