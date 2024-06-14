<div class="py-6 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            <!-- Event Rental Section -->
            <div class="mb-8 text-center">
                <a href="{{ route('sport-rental-list.show', $selectedHall) }}" 
                   class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-3 rounded-md 
                          transition-colors duration-300 ease-in-out 
                          focus:outline-none focus:ring-2 
                          focus:ring-indigo-500 focus:ring-opacity-50">
                    Go to Sport Rental Page
                </a>
            </div>

            <!-- Event Type Selection -->
            <div class="mb-6">
                <label for="eventType" class="block text-sm font-medium text-gray-700 mb-2">Select Event Type:</label>
                <div class="relative">
                    <select wire:model="eventType" id="eventType" class="mt-1 p-2 w-full border rounded-md appearance-none focus:border-indigo-500">
                        <option value="">-- Select Event Type --</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}">{{ $event->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('eventType')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Calendar Section -->
            <div class="mb-6">
                <label for="use_date" class="block text-sm font-medium text-gray-700">Select Date:</label>
                <input type="date" wire:model.defer="selectedDate" class="mt-1 p-2 border rounded-md w-full" min="{{ now()->format('Y-m-d') }}">
                @error('selectedDate')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Facility Rental Selection -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Would you like to rent facilities?</label>
                <div class="mt-2 space-y-2">
                    <label class="inline-flex items-center">
                        <input wire:model="rentFacility" wire:click="updateFacilitySection('yes')" type="radio" name="rentFacility" value="yes" class="form-radio text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2">Yes</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input wire:model="rentFacility" wire:click="updateFacilitySection('no')" type="radio" name="rentFacility" value="no" class="form-radio text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2">No</span>
                    </label>
                </div>
                @error('rentFacility')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Facility Selection -->
            @if($rentFacility == 'yes')
                <div>
                    <label for="facility" class="block text-sm font-medium text-gray-700 mb-2">Select Facilities:</label>
                    <div class="mt-1 p-2 w-full border rounded-md focus:border-indigo-500">
                        @foreach($facilities as $facility)
                            <div class="flex items-center justify-between mb-2">
                                <label class="flex-grow">{{ $facility->name }} (Available: {{ $availableQuantities[$facility->id] }})</label>
                                <input wire:model="facilityQuantities.{{ $facility->id }}" type="number" class="w-1/4 p-2 border rounded-md focus:border-indigo-500" placeholder="Quantity">
                            </div>
                            @error("facilityQuantities.{$facility->id}")
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Deposit Information -->
            <div class="mt-6 text-gray-600 text-sm">
                <p>For the event you rent, a RM200 deposit is required to protect the facilities.</p>
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
                                <button @click="showModal = false; $wire.submitForm()" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
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
        </div>
    </div>
</div>

@livewireScripts
@push('scripts')
@endpush

