<?php

namespace App\Livewire;

use App\Models\booked_courts;
use App\Models\Sport_Bookings;
use App\Models\Sport;
use App\Models\Sports;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class SportPaymentDetail extends Component
{
    public $bookingId;
    public $userName;
    public $userEmail;
    public $rentalDetails;
    public $cardName;
    public $cardNum;
    public $expMonth;
    public $expYear;
    public $cvv;
    public $sportName;  // Add this property to store sport name

    public function mount($bookingId)
    {
        $this->bookingId = $bookingId;
        $this->rentalDetails = Session::get('rentalDetails', []);
        $userDetails = Session::get('userDetails', []);
        $this->userName = $userDetails['name'] ?? 'N/A';
        $this->userEmail = $userDetails['email'] ?? 'N/A';

        // Fetch the sport name using the sport ID
        if (isset($this->rentalDetails['sport_id'])) {
            $sport = Sports::find($this->rentalDetails['sport_id']);
            $this->sportName = $sport ? $sport->name : 'N/A';
        }
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
            'cardNum' => 'required|string|regex:/^[0-9\s]{16,19}$/',
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
            // Check if booking_id exists in rentalDetails
            if (!isset($this->rentalDetails['booking_id'])) {
                throw new \Exception('Booking ID is missing from rental details');
            }

            $sportBooking = Sport_Bookings::find($this->rentalDetails['booking_id']);
            if ($sportBooking) {
                // Update the booking status to confirmed only if payment is successful
                $sportBooking->confirmed = 1;
                $sportBooking->save();
                Log::info('Booking confirmed', ['booking_id' => $sportBooking->id]);

                // Retrieve booked courts for the confirmed booking
                $bookedCourts = booked_courts::where('sport_bookings_id', $sportBooking->id)->get();

                // Update the corresponding time slots to not available only if the booking is confirmed
                foreach ($bookedCourts as $bookedCourt) {
                    TimeSlot::where('date', $sportBooking->use_date)
                        ->where('time', $bookedCourt->start_time)
                        ->where('court_rental_id', $sportBooking->court_rental_id)
                        ->where('court_number', $bookedCourt->court_number)
                        ->update(['available' => false]);
                }
            }

            DB::commit();

            // Set success message
            session()->flash('success', 'Payment completed successfully!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment processing error: ' . $e->getMessage());
            session()->flash('error', 'Payment failed. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.sport-payment-detail', [
            'rentalDetails' => $this->rentalDetails,
            'userName' => $this->userName,
            'userEmail' => $this->userEmail,
            'sportName' => $this->sportName,
        ]);
    }
}

