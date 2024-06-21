<?php

namespace App\Livewire;

use App\Models\event_facility_bookings;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\Booked_Facility;
use App\Models\Event_Facility_Booking;
use App\Models\Events;

class EventFacilityPaymentDetail extends Component
{
    public $cardName;
    public $cardNum;
    public $expMonth;
    public $expYear;
    public $cvv;
    public $bookingId;
    public $rentalDetails;
    public $event;
    public $facilities = [];

    public function mount($bookingId)
    {
        $this->bookingId = $bookingId;
        $this->rentalDetails = session('rentalDetails');
        
        if (isset($this->rentalDetails['eventId'])) {
            $this->event = Events::find($this->rentalDetails['eventId']);
        }
        
        $this->loadFacilityDetails(); // Load facility details when component mounts
    }

    protected function loadFacilityDetails()
    {
        $this->facilities = Booked_Facility::whereHas('eventFacilityBooking', function ($query) {
            $query->where('id', $this->bookingId);
        })
        ->with(['facility'])
        ->get();
    }

    public function submitPayment()
    {
        // Convert month name to number
        $monthNames = [
            'January' => '01', 'February' => '02', 'March' => '03', 'April' => '04',
            'May' => '05', 'June' => '06', 'July' => '07', 'August' => '08',
            'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12'
        ];
        $this->expMonth = $monthNames[$this->expMonth] ?? null;
    
        $validatedData = $this->validate([
            'cardName' => 'required|string|max:255',
            'cardNum' => 'required|string|regex:/^\d{16}$/|max:16',
            'expMonth' => ['required', 'string', 'size:2', 'regex:/^(0[1-9]|1[0-2])$/'],
            'expYear' => 'required|integer|min:' . now()->year,
            'cvv' => 'required|string|digits:3',
        ], [
            'cardNum.regex' => 'The credit card number format is invalid.',
            'expMonth.size' => 'The expiration month must be 2 characters.',
            'expMonth.regex' => 'The expiration month format is invalid.',
            'expYear.min' => 'The expiration year must be a valid future year.',
        ]);
    
        DB::beginTransaction();
        try {
            // Update booking to confirmed
            $booking = event_facility_bookings::findOrFail($this->bookingId);
            $booking->confirmed = true;
            $booking->save();
    
            DB::commit();
            session()->flash('success', 'Payment completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Payment failed. Please try again.');
        }
    }
    
    public function render()
    {
        return view('livewire.event-facility-payment-detail', [
            'user' => Auth::user(),
            'event' => $this->event,
            'rentalDetails' => $this->rentalDetails,
            'facilities' => $this->facilities,
        ]);
    }
}
