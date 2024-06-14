<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Booked_Courts;
use App\Models\Sport_Bookings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class DateTimeAvailability extends Component
{
    public $date;
    public $selectedTimes = [];
    public $numberOfCourts;
    public $selectedHall;
    public $selectedSport;

    protected $listeners = ['sportSelected' => 'updateAvailableTimeSlots'];

    public function mount($numberOfCourts, $selectedHall, $selectedSport)
    {
        $this->numberOfCourts = $numberOfCourts;
        $this->selectedHall = $selectedHall;
        $this->selectedSport = $selectedSport;
        $this->date = Carbon::now()->format('Y-m-d');
        $this->fetchAvailableTimeSlots();
    }

    public function updatedDate()
    {
        $this->fetchAvailableTimeSlots();
    }

    public function fetchAvailableTimeSlots()
    {
        $this->reset('selectedTimes');
        $startTime = Carbon::parse($this->date . ' 09:00:00');
        $endTime = Carbon::parse($this->date . ' 23:00:00');

        for ($courtNumber = 1; $courtNumber <= $this->numberOfCourts; $courtNumber++) {
            $court = "Court_$courtNumber";
            $this->selectedTimes[$court] = [];
            $slotStartTime = $startTime->copy();
            while ($slotStartTime < $endTime) {
                $slotEndTime = $slotStartTime->copy()->addHour();
                $timeSlot = $slotStartTime->format('h:ia') . ' - ' . $slotEndTime->format('h:ia');
                $isAvailable = $this->checkSlotAvailability($court, $slotStartTime, $slotEndTime);
                $this->selectedTimes[$court][] = [
                    'time' => $timeSlot,
                    'selected' => false,
                    'available' => $isAvailable,
                ];
                $slotStartTime->addHour();
            }
        }
    }

    private function checkSlotAvailability($court, $startTime, $endTime)
    {
        $courtNumber = $this->getCourtNumber($court);

        $existingBookings = DB::table('booked_courts')
            ->join('sport_bookings', 'booked_courts.sport_bookings_id', '=', 'sport_bookings.id')
            ->where('booked_courts.court_number', $courtNumber)
            ->where('booked_courts.start_time', '<=', $endTime->format('H:i:s'))
            ->where('booked_courts.end_time', '>=', $startTime->format('H:i:s'))
            ->where('sport_bookings.use_date', $this->date)
            ->where('sport_bookings.confirmed', 1)
            ->exists();

        return !$existingBookings;
    }

    public function save()
    {
        $this->validate([
            'date' => 'required|date|after_or_equal:today',
            'selectedTimes.*.*.selected' => 'boolean',
        ]);

        $user = Auth::user();
        if (!$user) {
            Log::error('User not authenticated');
            return;
        }

        $totalAmount = $this->calculateTotalAmount();
        Log::info("Total amount calculated: $totalAmount");

        DB::beginTransaction();
        try {
            $sportBooking = Sport_Bookings::create([
                'users_id' => $user->id,
                'halls_id' => $this->selectedHall,
                'sports_id' => $this->selectedSport->id,
                'use_date' => $this->date,
                'total_amount' => $totalAmount,
                'confirmed' => false,
                'reserved_at' => now(),
            ]);

            foreach ($this->selectedTimes as $court => $timeSlots) {
                foreach ($timeSlots as $timeSlot) {
                    if ($timeSlot['selected']) {
                        Log::info("Saving booked court: {$court}, Time Slot: {$timeSlot['time']}");
                        Booked_Courts::create([
                            'sport_bookings_id' => $sportBooking->id,
                            'court_number' => $this->getCourtNumber($court),
                            'start_time' => $this->getStartTime($timeSlot['time']),
                            'end_time' => $this->getEndTime($timeSlot['time']),
                        ]);
                    }
                }
            }

            DB::commit();
            $this->reset('selectedTimes');
            $this->dispatch('bookingSuccessful');

            Log::info('Redirecting to payment page', ['bookingId' => $sportBooking->id]);

            Session::put('rentalDetails', [
                'booking_id' => $sportBooking->id,
                'date' => $this->date,
                'selectedTimes' => $this->selectedTimes,
                'totalAmount' => $totalAmount,
                'sport_id' => $this->selectedSport->id,
            ]);

            Session::put('userDetails', [
                'name' => $user->name,
                'email' => $user->email,
            ]);

            return redirect()->route('sportPayment.show', ['bookingId' => $sportBooking->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving booking: ' . $e->getMessage());
            session()->flash('error', 'Booking failed. Please try again.');
        }
    }

    protected function calculateTotalAmount()
    {
        $totalAmount = 0;
        $rentalRate = DB::table('court_rentals')
            ->where('halls_id', $this->selectedHall)
            ->where('sports_id', $this->selectedSport->id)
            ->value('sport_rental_rate');

        Log::info("Rental rate: $rentalRate");

        foreach ($this->selectedTimes as $court => $timeSlots) {
            foreach ($timeSlots as $timeSlot) {
                if ($timeSlot['selected']) {
                    [$start, $end] = explode(' - ', $timeSlot['time']);
                    $startTime = Carbon::createFromFormat('h:ia', $start)->setDateFrom(Carbon::parse($this->date));
                    $endTime = Carbon::createFromFormat('h:ia', $end)->setDateFrom(Carbon::parse($this->date));

                    if ($endTime->lessThan($startTime)) {
                        $endTime->addDay();
                    }

                    $durationInMinutes = $endTime->diffInMinutes($startTime);
                    $durationInHours = $durationInMinutes / 60;
                    $subtotal = $rentalRate * $durationInHours;
                    $totalAmount += $subtotal;
                    Log::info("Subtotal for time slot {$timeSlot['time']}: $subtotal");
                }
            }
        }

        return $totalAmount;
    }

    protected function getCourtNumber($court)
    {
        return (int)str_replace('Court_', '', $court);
    }

    protected function getStartTime($timeSlot)
    {
        return Carbon::createFromFormat('h:ia', explode(' - ', $timeSlot)[0])->format('H:i:s');
    }

    protected function getEndTime($timeSlot)
    {
        return Carbon::createFromFormat('h:ia', explode(' - ', $timeSlot)[1])->format('H:i:s');
    }

    public function render()
    {
        return view('livewire.date-time-availability');
    }
}
