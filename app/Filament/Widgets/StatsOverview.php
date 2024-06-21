<?php

namespace App\Filament\Widgets;

use App\Models\Event_Facility_Bookings;
use App\Models\Sport_Bookings;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            // New Users Count
            Stat::make('New Users', User::count())
                ->description('Total new users that have joined')
                ->descriptionIcon('heroicon-o-user-plus')
                ->color('primary'),

            // Total Sport Bookings (Confirmed)
            Stat::make('Sport Bookings', Sport_Bookings::where('confirmed', 1)->count())
                ->description('Total number of sport bookings')
                ->descriptionIcon('heroicon-o-clipboard-document-check')
                ->color('success'),

            // Total Event Bookings (Confirmed)
            Stat::make('Event Bookings', Event_Facility_Bookings::where('confirmed', 1)->count())
                ->description('Total number of event bookings')
                ->descriptionIcon('heroicon-o-clipboard-document-check')
                ->color('success'),

            // Sport Booking Revenue (Confirmed)
            Stat::make('Sport Booking Revenue', 'RM' . number_format(Sport_Bookings::where('confirmed', 1)->sum('total_amount'), 2))
                ->description('Total revenue from sport bookings')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('danger'),

            // Event Booking Revenue (Confirmed)
            Stat::make('Event Booking Revenue', 'RM' . number_format(Event_Facility_Bookings::where('confirmed', 1)->sum('total_amount'), 2))
                ->description('Total revenue from event bookings')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('danger'),
        ];
    }
}
