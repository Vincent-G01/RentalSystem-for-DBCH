<?php

namespace App\Livewire;

use App\Models\sport_bookings;
use Carbon\Carbon;
use App\Models\Sports;
use Livewire\Component;
use App\Models\TimeSlot;
use Carbon\CarbonInterval;
use App\Models\booked_courts;
use App\Models\Court_Rental;
use App\Models\SportBooking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SportRental extends Component
{
    public $selectedHall;
    public $selectedSport;
    public $numberOfCourts;
    public $sports;
    public $date;
    public $selectedTimes = [];
    public $halls;
    public $timeSlots;

    protected $listeners = [
        'sportSelected' => 'updateAvailableTimeSlots',
        'bookingDetailsSaved' => 'showRentalModal'
    ];

    public function mount($selectedHall)
    {
        $this->selectedHall = $selectedHall;
        $this->sports = Court_Rental::where('halls_id', $this->selectedHall)->with('sports')->get();
        $this->date = now()->format('Y-m-d');
    }

    public function selectSport($sportId)
    {
        $this->selectedSport = Sports::with('court_rentals')->find($sportId);
        $court_rental = $this->selectedSport->court_rentals->where('halls_id', $this->selectedHall)->first();
        if ($court_rental) {
            $this->numberOfCourts = $court_rental->number_of_court;
            $this->fetchAvailableTimeSlots();
            $this->dispatch('sportSelected', $this->numberOfCourts, $this->selectedHall, $this->selectedSport->id);
        }
    }

    public function updatedDate()
    {
        $this->fetchAvailableTimeSlots();
    }

    public function fetchAvailableTimeSlots()
{
    $this->selectedTimes = [];
    $startTime = Carbon::createFromTime(9, 0, 0, 'Asia/Singapore');
    $endTime = Carbon::createFromTime(23, 0, 0, 'Asia/Singapore');
    $interval = CarbonInterval::hour();
    $now = Carbon::now('Asia/Singapore');
    $thirtyDaysLater = $now->copy()->addDays(30);

    $courtRentalId = $this->selectedSport->court_rentals->where('halls_id', $this->selectedHall)->first()->id;

    for ($current = $startTime; $current->lessThan($endTime); $current->add($interval)) {
        foreach (range(1, $this->numberOfCourts) as $courtNumber) {
            $courtName = 'Court_' . $courtNumber;
            $timeSlot = TimeSlot::where('date', $this->date)
                ->where('time', $current->format('H:i:s'))
                ->where('court_rental_id', $courtRentalId)
                ->where('court_number', $courtNumber)
                ->first();

            $booking = Sport_Bookings::where('halls_id', $this->selectedHall)
                ->where('sports_id', $this->selectedSport->id)
                ->where('use_date', $this->date)
                ->where('confirmed', 1)
                ->whereHas('bookedCourts', function ($query) use ($current, $courtNumber) {
                    $query->where('start_time', $current->format('H:i:s'))
                        ->where('court_number', $courtNumber);
                })
                ->first();

            $isPast = $now->greaterThanOrEqualTo(Carbon::parse($this->date . ' ' . $current->format('H:i:s')));
            $isBeyondThirtyDays = Carbon::parse($this->date)->greaterThan($thirtyDaysLater);

            $this->selectedTimes[$courtName][] = [
                'time' => $current->format('H:i') . ' - ' . $current->copy()->addHour()->format('H:i'),
                'available' => !$isPast && !$isBeyondThirtyDays && ($timeSlot ? $timeSlot->available : true) && !$booking,
                'selected' => false,
            ];
        }
    }
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
        session()->flash('error', 'User not authenticated. Please log in.');
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
                    $courtNumber = $this->getCourtNumber($court);
                    $start = Carbon::createFromFormat('H:i', explode(' - ', $timeSlot['time'])[0])->format('H:i:s');
                    $end = Carbon::createFromFormat('H:i', explode(' - ', $timeSlot['time'])[1])->format('H:i:s');

                    Log::info("Saving booked court: {$court}, Time Slot: {$timeSlot['time']}");
                    booked_courts::create([
                        'sport_bookings_id' => $sportBooking->id,
                        'court_number' => $courtNumber,
                        'start_time' => $start,
                        'end_time' => $end,
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
            'court_rental_id' => $sportBooking->court_rental_id,
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


    
    

protected function isSlotAvailable($start, $end, $courtNumber)
{
    $slot = TimeSlot::where('date', $this->date)
        ->where('time', $start->format('H:i:s'))
        ->where('court_rental_id', $this->selectedSport->court_rentals->where('halls_id', $this->selectedHall)->first()->id)
        ->where('court_number', $courtNumber)
        ->where('available', true)
        ->first();
    return $slot ? true : false;
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
                $startTime = Carbon::createFromFormat('H:i', $start)->setDateFrom(Carbon::parse($this->date));
                $endTime = Carbon::createFromFormat('H:i', $end)->setDateFrom(Carbon::parse($this->date));

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
    if (preg_match('/Court_(\d+)/', $court, $matches)) {
        return (int)$matches[1];
    }
    throw new \Exception("Invalid court format: {$court}");
}


public function showRentalModal($rentalInfo)
{
    $this->dispatch('showRentalModal', $rentalInfo);
}

public function render()
{
    return view('livewire.sport-rental', [
        'sports' => $this->sports,
        'halls' => $this->halls,
        'selectedTimes' => $this->selectedTimes,
    ]);
}
}

