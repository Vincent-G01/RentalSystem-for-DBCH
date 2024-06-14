<div class="py-6 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Event Rental Section -->
            <div class="mb-8 text-center">
                <a href="{{ route('event-rental-list.show', $selectedHall) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-3 rounded-md transition-colors duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">Go to Event Rental Page</a>
            </div>

            <!-- Sport Selection Section -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">Select Sport</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($sports as $sport)
                        <button class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 w-full" wire:click="selectSport({{ $sport->sports_id }})">
                            {{ $sport->sports->name }} ({{ $sport->number_of_court }} Courts)
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Date and Time Availability -->
            @if($selectedSport)
                <section class="font-sans text-gray-900 antialiased">
                    <div class="mb-4">
                        <h2 class="text-xl font-semibold mb-4">Select Date</h2>
                        <div class="mb-4">
                            <input type="date" wire:model="date" class="mt-1 p-2 border rounded-md w-full" min="{{ now()->format('Y-m-d') }}">
                            <button wire:click="fetchAvailableTimeSlots" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Update Time Slots</button>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold mb-4">Available Courts and Time Slots</h2>
                        @foreach($selectedTimes as $court => $timeSlots)
                            <div class="mb-4">
                                <h3 class="font-semibold text-lg">{{ str_replace('_', ' ', $court) }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-2 gap-y-1 mt-2">
                                    @foreach($timeSlots as $index => $timeSlot)
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" wire:model="selectedTimes.{{ $court }}.{{ $index }}.selected"
                                                   class="form-checkbox text-blue-500 focus:ring-blue-400 h-4 w-4"
                                                   {{ !$timeSlot['available'] ? 'disabled' : '' }}>
                                            <span>{{ $timeSlot['time'] }}</span>
                                            @if (!$timeSlot['available'])
                                                <span class="text-red-500 ml-2">(Unavailable)</span>
                                            @endif
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Modal for Confirmation -->
                    <div x-data="{ showModal: false }">
                        <!-- Button to trigger modal -->
                        <button @click="showModal = true" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            Reserve
                        </button>
                        
                        <!-- Modal -->
                        <div x-show="showModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <!-- Background overlay -->
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                                
                                <!-- Modal Panel -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                
                                <!-- Modal Content -->
                                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                                    Confirm Reservation
                                                </h3>
                                                <div class="mt-2">
                                                    <p class="text-sm text-gray-500">
                                                        Are you sure you want to proceed with this reservation?
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button @click="showModal = false; @this.call('save')" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Confirm
                                        </button>
                                        
                                        <button @click="showModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        </div>
    </div>
</div>
