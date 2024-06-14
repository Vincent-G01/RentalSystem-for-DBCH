<?php


namespace App\Livewire;

use App\Models\event_facility_bookings;
use Livewire\Component;
use Carbon\Carbon;

class EventCalendar extends Component
{
    public $selectedDate;
    public $bookedDates = [];

    public function mount()
    {
        // Fetch booked dates with rental_type = 'event' from the database
        $this->bookedDates = event_facility_bookings::where('rental_type', 'event')
            ->pluck('use_date')
            ->map(function ($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })
            ->toArray();
    }

    public function updatedSelectedDate($value)
    {
        $this->selectedDate = $value;
    }
    

    public function render()
    {
        return view('livewire.event-calendar', [
            'bookedDates' => $this->bookedDates,
        ]);
    }
}

