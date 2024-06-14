<?php

namespace Database\Seeders;

use App\Models\TimeSlot;
use App\Models\Court_Rental;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TimeSlotSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            $courtRentals = Court_Rental::all();

            foreach ($courtRentals as $courtRental) {
                for ($day = 0; $day < 30; $day++) {
                    $date = Carbon::now()->addDays($day)->format('Y-m-d');
                    for ($hour = 9; $hour <= 23; $hour++) {
                        for ($courtNumber = 1; $courtNumber <= $courtRental->number_of_court; $courtNumber++) {
                            TimeSlot::updateOrCreate(
                                [
                                    'date' => $date,
                                    'time' => sprintf('%02d:00', $hour),
                                    'court_rental_id' => $courtRental->id,
                                    'court_number' => $courtNumber,
                                ],
                                ['available' => true]
                            );
                        }
                    }
                }
            }

            // Disable time slots beyond 30 days
            $dateLimit = Carbon::now()->addDays(30)->format('Y-m-d');
            TimeSlot::where('date', '>', $dateLimit)->update(['available' => false]);
        });
    }
}
