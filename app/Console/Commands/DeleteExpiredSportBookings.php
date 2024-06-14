<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Sport_Bookings;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteExpiredSportBookings extends Command
{   
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-expired-sport-bookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete sport bookings that are older than 15 minutes and not confirmed';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredTime = Carbon::now()->subMinutes(15);

        DB::transaction(function () use ($expiredTime) {
            $expiredBookings = Sport_Bookings::where('confirmed', false)
                ->where('created_at', '<', $expiredTime)
                ->get();

            foreach ($expiredBookings as $booking) {
                $booking->delete();
                Log::info('Deleted expired booking', ['booking_id' => $booking->id]);
            }
        });

        $this->info('Expired bookings deleted successfully.');
    
    }
}

