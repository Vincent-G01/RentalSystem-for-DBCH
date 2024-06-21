<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold mb-6">My Booking Records</h2>

    <div x-data="{ tab: 'upcoming' }">
        <ul class="flex border-b">
            <li class="-mb-px mr-1">
                <a class="bg-white inline-block py-2 px-4 text-blue-500 font-semibold" href="#upcoming" @click.prevent="tab = 'upcoming'" :class="{ 'border-l border-t border-r rounded-t text-blue-700': tab === 'upcoming' }">Upcoming</a>
            </li>
            <li class="-mb-px">
                <a class="bg-white inline-block py-2 px-4 text-blue-500 font-semibold" href="#past" @click.prevent="tab = 'past'" :class="{ 'border-l border-t border-r rounded-t text-blue-700': tab === 'past' }">Past</a>
            </li>
        </ul>

        <!-- Upcoming Sports Bookings -->
        <div class="bg-white p-4 border-l border-r border-b" x-show="tab === 'upcoming'">
            <h3 class="text-xl font-semibold mb-4">Upcoming Sports Bookings</h3>
            <ul>
                @forelse ($upcomingSportBookings as $booking)
                    <li class="mb-4">
                        <div class="p-4 bg-gray-100 rounded-md">
                            <p><strong>Date:</strong> {{ $booking->formatted_date }}</p>
                            <p><strong>Sport:</strong> {{ $booking->Sports->name ?? 'N/A' }}</p>
                            <p><strong>Hall:</strong> {{ $booking->halls->name ?? 'N/A' }}</p>
                            <p><strong>Court:</strong> {{ $booking->bookedCourts->pluck('court_number')->join(', ') }}</p>
                            <p><strong>Time Slot:</strong>
                                @foreach ($booking->bookedCourts as $court)
                                    {{ $court->start_time }} - {{ $court->end_time }}<br>
                                @endforeach
                            </p>
                            <p><strong>Total Amount:</strong> RM{{ number_format($booking->total_amount, 2) }}</p>
                            <p><strong>Confirmed:</strong> {{ $booking->confirmed ? 'Yes' : 'No' }}</p>
                        </div>
                    </li>
                @empty
                    <li>No upcoming sports bookings.</li>
                @endforelse
            </ul>
        </div>

        <!-- Upcoming Event Bookings -->
        <div class="bg-white p-4 border-l border-r border-b" x-show="tab === 'upcoming'">
            <h3 class="text-xl font-semibold mb-4">Upcoming Event Bookings</h3>
            <ul>
                @forelse ($upcomingEventBookings as $booking)
                    <li class="mb-4">
                        <div class="p-4 bg-gray-100 rounded-md">
                            <p><strong>Date:</strong> {{ $booking->formatted_date }}</p>
                            <p><strong>Hall:</strong> {{ $booking->halls->name ?? 'N/A' }}</p>
                            <p><strong>Event:</strong> {{ $booking->events->name ?? 'N/A' }}</p>
                            @if($booking->bookedFacilities->isNotEmpty())
                                <h4 class="font-semibold mt-4">Facilities:</h4>
                                <ul>
                                    @foreach ($booking->bookedFacilities as $facility)
                                        <li>{{ $facility->facility->name ?? 'N/A' }} - {{ $facility->quantity }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <p><strong>Total Amount:</strong> RM{{ number_format($booking->total_amount, 2) }}</p>
                            <p><strong>Confirmed:</strong> {{ $booking->confirmed ? 'Yes' : 'No' }}</p>
                            <p>*Deposit RM200 is included in the Total Amount*</p>
                        </div>
                    </li>
                @empty
                    <li>No upcoming event bookings.</li>
                @endforelse
            </ul>
        </div>

        <!-- Past Sports Bookings -->
        <div class="bg-white p-4 border-l border-r border-b" x-show="tab === 'past'">
            <h3 class="text-xl font-semibold mb-4">Past Sports Bookings</h3>
            <ul>
                @forelse ($pastSportBookings as $booking)
                    <li class="mb-4">
                        <div class="p-4 bg-gray-100 rounded-md">
                            <p><strong>Date:</strong> {{ $booking->formatted_date }}</p>
                            <p><strong>Sport:</strong> {{ $booking->Sports->name ?? 'N/A' }}</p>
                            <p><strong>Hall:</strong> {{ $booking->Halls->name ?? 'N/A' }}</p>
                            <p><strong>Court:</strong> {{ $booking->bookedCourts->pluck('court_number')->join(', ') }}</p>
                            <p><strong>Time Slot:</strong>
                                @foreach ($booking->bookedCourts as $court)
                                    {{ $court->start_time }} - {{ $court->end_time }}<br>
                                @endforeach
                            </p>
                            <p><strong>Total Amount:</strong> RM{{ number_format($booking->total_amount, 2) }}</p>
                            <p><strong>Confirmed:</strong> {{ $booking->confirmed ? 'Yes' : 'No' }}</p>
                        </div>
                    </li>
                @empty
                    <li>No past sports bookings.</li>
                @endforelse
            </ul>
        </div>

        <!-- Past Event Bookings -->
        <div class="bg-white p-4 border-l border-r border-b" x-show="tab === 'past'">
            <h3 class="text-xl font-semibold mb-4">Past Event Bookings</h3>
            <ul>
                @forelse ($pastEventBookings as $booking)
                    <li class="mb-4">
                        <div class="p-4 bg-gray-100 rounded-md">
                            <p><strong>Date:</strong> {{ $booking->formatted_date }}</p>
                            <p><strong>Hall:</strong> {{ $booking->halls->name ?? 'N/A' }}</p>
                            <p><strong>Event:</strong> {{ $booking->events->name ?? 'N/A' }}</p>
                            @if($booking->bookedFacilities->isNotEmpty())
                                <h4 class="font-semibold mt-4">Facilities:</h4>
                                <ul>
                                    @foreach ($booking->bookedFacilities as $facility)
                                        <li>{{ $facility->facility->name ?? 'N/A' }} - {{ $facility->quantity }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <p><strong>Total Amount:</strong> RM{{ number_format($booking->total_amount, 2) }}</p>
                            <p><strong>Confirmed:</strong> {{ $booking->confirmed ? 'Yes' : 'No' }}</p>
                            <p>*Deposit RM200 is included in the Total Amount*</p>
                        </div>
                    </li>
                @empty
                    <li>No past event bookings.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
