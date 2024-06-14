<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Booking; // Import the Booking model
use Illuminate\Console\Command;

class PurgeExpiredReservationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:purge-expired-reservations-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge expired unconfirmed bookings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredBookings = Booking::where('reserved_at', '<=', Carbon::now()->subMinutes(config('app.appointmentTimeout')))
                                  ->where('confirmed', false)
                                  ->get();

        foreach ($expiredBookings as $booking) {
            $booking->delete();
            $this->info("Deleted expired booking ID: {$booking->id}");
        }

        $this->info('Expired bookings have been purged successfully.');
    }
}

