<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white">

                <!-- Carousel Section -->
                <div class="bg-white p-4">

                    <div id="default-carousel" class="relative w-full h-auto" data-carousel="slide">
                        <div class="relative h-96 overflow-hidden rounded-lg">
                            @if($hall->diagram)
                                <img src="{{ asset('storage/' . $hall->diagram) }}" class="absolute w-full h-full object-cover" alt="Hall Diagram">
                            @else
                                <p class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-gray-500">No diagram available</p>
                            @endif
                        </div>

                        <!-- Slider Indicators -->
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 space-x-3">
                            @foreach($halls as $key => $h)
                                <button type="button" class="w-3 h-3 rounded-full {{ $key == 0 ? 'bg-black' : 'bg-gray-300' }}" aria-current="{{ $key == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $key + 1 }}" data-carousel-slide-to="{{ $key }}"></button>
                            @endforeach
                        </div>

                        <!-- Slider Controls -->
                        <div class="absolute top-1/2 left-0 transform -translate-y-1/2">
                            <button type="button" class="px-4 py-2 bg-white/30 rounded-full focus:outline-none">
                                <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                </svg>
                            </button>
                        </div>

                        <div class="absolute top-1/2 right-0 transform -translate-y-1/2">
                            <button type="button" class="px-4 py-2 bg-white/30 rounded-full focus:outline-none">
                                <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Rental Section -->
                <div class="bg-white p-4">
                    <div class="max-w-sm mx-auto">
                        <div class="bg-blue-800 px-6 py-4 rounded-t-lg">
                            
                        </div>

                        <!-- Sport Activity -->
                        <div class="bg-white px-6 py-4 border-t border-gray-200">
                            <h5 class="mb-3 font-semibold text-gray-700">Sport Activity</h5>
                            <a href="{{ route('sport-rental-list.show',  $hall['id']) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                Rent Sport
                                <svg class="w-3.5 h-3.5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                            </a>
                        </div>

                        <!-- Event Rental -->
                        <div class="bg-white px-6 py-4">
                            <h5 class="mb-3 font-semibold text-gray-700">Event Rental</h5>
                            <a href="{{ route('event-rental-list.show',  $hall['id']) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                Rent Event
                                <svg class="w-3.5 h-3.5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hall Information Section -->
            <div class="bg-white p-4 mt-4">
                <h2 class="text-3xl font-medium text-gray-900">{{ $hall->name }}</h2>
                <div class="mt-4 text-gray-600">
                    <p><span class="font-semibold">Address:</span> <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($hall->address) }}" target="_blank" class="text-blue-500 hover:underline">{{ $hall->address }}</a></p>
                    <p><span class="font-semibold">Staff Onsite:</span> {{ $hall->users->name }}</p>
                    <p><span class="font-semibold">Staff Tel No:</span> {{ $hall->users->phone }}</p>
                </div>
            </div>

            <!-- Sports, Events, Facilities Section -->
            <div class="bg-white p-4 mt-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <!-- Sports Section -->
                    <div class="bg-white p-4">
                        <h2 class="text-lg font-semibold mb-4">Sports</h2>
                        @if($hall->courtRentals->isNotEmpty())
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($hall->courtRentals as $courtRental)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <p class="text-gray-800 font-semibold">{{ $courtRental->sports->name }}</p>
                                        <p class="text-gray-600">Rental Rate: RM {{ number_format($courtRental->sport_rental_rate, 2) }}/H</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>No courts available for this hall.</p>
                        @endif
                    </div>

                    <!-- Events Section -->
                    <div class="bg-white p-4">
                        <h2 class="text-lg font-semibold mb-4">Events</h2>
                        @if($hall->eventFacilityRentals->isNotEmpty())
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @php $uniqueEventNames = []; @endphp
                                @foreach($hall->eventFacilityRentals as $eventFacilityRental)
                                    @if(!in_array($eventFacilityRental->events->name, $uniqueEventNames))
                                        <div class="border border-gray-200 rounded-lg p-4">
                                            <p class="text-gray-800 font-semibold">{{ $eventFacilityRental->events->name }}</p>
                                            <p class="text-gray-600">Rental Rate: RM {{ number_format($eventFacilityRental->event_rental_rate, 2) }}/Day</p>
                                        </div>
                                        @php $uniqueEventNames[] = $eventFacilityRental->events->name; @endphp
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p>No events available for this hall.</p>
                        @endif
                    </div>

                    <!-- Facilities Section -->
                    <div class="bg-white p-4">
                        <h2 class="text-lg font-semibold mb-4">Facilities</h2>
                        @if($hall->eventFacilityRentals->isNotEmpty())
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($hall->eventFacilityRentals as $rental)
                                    @if($rental->facilities_id)
                                        <div class="border border-gray-200 rounded-lg p-4">
                                            <p class="text-gray-800 font-semibold">{{ $rental->facilities->name }}</p>
                                            <p class="text-gray-600">Rental Rate: RM {{ number_format($rental->facility_rental_rate, 2) }}/Item</p>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p>No facilities available for this hall.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
