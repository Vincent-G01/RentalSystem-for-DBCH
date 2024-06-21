<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Halls;
use App\Models\Events;
use App\Models\Facilities;
use App\Models\Booked_Facility;
use App\Models\Event_Facility_Bookings;
use App\Models\Event_Facility_Rental;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EventRental extends Component
{
    public $selectedHall;
    public $eventType = null;
    public $rentFacility = 'no';
    public $facilityQuantities = [];
    public $availableQuantities = [];
    public $hall;
    public $events;
    public $facilities;
    public $selectedDate;
    public $totalAmount;

    public function mount($selectedHall)
    {
        $this->selectedHall = $selectedHall;
        $this->selectedDate = Carbon::now()->format('Y-m-d'); 
        $this->loadData();
    }

    public function loadData()
    {
        $this->events = Events::whereHas('event_facility_rentals', function ($query) {
            $query->where('halls_id', $this->selectedHall);
        })->get();

        $this->facilities = Facilities::whereHas('event_facility_rentals', function ($query) {
            $query->where('halls_id', $this->selectedHall);
        })->get();

        foreach ($this->facilities as $facility) {
            $facilityRental = Event_Facility_Rental::where('halls_id', $this->selectedHall)
                ->where('facilities_id', $facility->id)
                ->first();

            $this->availableQuantities[$facility->id] = $facilityRental ? $facilityRental->quantity : 0;
        }

        $this->hall = Halls::find($this->selectedHall);
    }

    public function updatedRentFacility()
    {
        if ($this->rentFacility == 'no') {
            $this->facilityQuantities = [];
        }
    }

    public function updateFacilitySection($value)
    {
        $this->rentFacility = $value;
    }

    public function updatedSelectedDate($value)
    {
        $this->selectedDate = $value;
        Log::info('Selected date updated: ' . $value);
    }

    public function rules()
    {
        $rules = [
            'eventType' => 'required|exists:events,id',
            'selectedDate' => [
                'required',
                'date',
                'after_or_equal:today',
                function ($attribute, $value, $fail) {
                    $existingBooking = Event_Facility_Bookings::where('halls_id', $this->selectedHall)
                        ->where('events_id', $this->eventType)
                        ->where('use_date', $value)
                        ->where('confirmed', 1) // Only check for confirmed bookings
                        ->exists();

                    if ($existingBooking) {
                        $fail('The selected date is already booked for this event.');
                    }
                },
            ],
        ];

        if ($this->rentFacility === 'yes') {
            foreach ($this->facilities as $facility) {
                $rules["facilityQuantities.{$facility->id}"] = [
                    'nullable',
                    'integer',
                    'min:1',
                    'max:' . $this->availableQuantities[$facility->id]
                ];
            }
        }

        return $rules;
    }

    public function calculateTotalAmount()
    {
        $totalAmount = 0;

        $eventRental = Event_Facility_Rental::where('halls_id', $this->selectedHall)
            ->where('events_id', $this->eventType)
            ->first();

        if ($eventRental) {
            $totalAmount += $eventRental->event_rental_rate;
        }

        $totalAmount += 200;

        if ($this->rentFacility === 'yes') {
            foreach ($this->facilityQuantities as $facilityId => $quantity) {
                if ($quantity > 0) {
                    $facilityRental = Event_Facility_Rental::where('halls_id', $this->selectedHall)
                        ->where('facilities_id', $facilityId)
                        ->first();

                    if ($facilityRental) {
                        $totalAmount += $facilityRental->facility_rental_rate * $quantity;
                    }
                }
            }
        }

        return $totalAmount;
    }

    public function submitForm()
    {
        $this->validate();

        $user = Auth::user();
        if (!$user) {
            Log::error('User not authenticated');
            return;
        }

        $this->totalAmount = $this->calculateTotalAmount();

        DB::beginTransaction();
        try {
            $booking = Event_Facility_Bookings::create([
                'users_id' => $user->id,
                'halls_id' => $this->selectedHall,
                'events_id' => $this->eventType,
                'rental_type' => 'event',
                'use_date' => $this->selectedDate,
                'total_amount' => $this->totalAmount,
                'confirmed' => false,
                'reserved_at' => now(),
            ]);

            if ($this->rentFacility === 'yes') {
                foreach ($this->facilityQuantities as $facility_id => $quantity) {
                    if ($quantity > 0) {
                        Booked_Facility::create([
                            'event_facility_booking_id' => $booking->id,
                            'facility_id' => $facility_id,
                            'quantity' => $quantity,
                        ]);
                    }
                }
            }

            // Store rental details in session
            session([
                'rentalDetails' => [
                    'eventId' => $this->eventType,
                    'eventType' => $this->eventType,
                    'selectedDate' => $this->selectedDate,
                    'rentFacility' => $this->rentFacility,
                    'facilityQuantities' => $this->facilityQuantities,
                    'totalAmount' => $this->totalAmount,
                    'bookingId' => $booking->id,
                ]
            ]);
            
            DB::commit();
            
            session()->flash('message', 'Event booked successfully!');
            return redirect()->route('EventFacilityPayment.show', ['bookingId' => $booking->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Booking failed: ' . $e->getMessage());
            session()->flash('error', 'Booking failed. Please try again.');
            return redirect()->back();
        }
    }

    public function render()
    {
        return view('livewire.event-rental', [
            'events' => $this->events,
            'facilities' => $this->facilities,
            'availableQuantities' => $this->availableQuantities,
            'hall' => $this->hall,
        ]);
    }
}
