<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="py-12 px-6">
                <h1 class="text-3xl font-bold text-center text-gray-900">
                    Cameron Highland<br>
                    Sports, Events, and Facilities
                </h1>
                <p class="mt-4 text-center text-gray-600">
                    Booking and Payments for all DBCH Halls, Courts, and Sports Complexes can be made online using the system.
                </p>

                <div class="mt-8 flex justify-center">
                    <!-- city component -->
                    <label for="city" class="sr-only">Select City:</label>
                    <select wire:model="selectedCity" id="city" class="form-select w-64 border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md">
                        <option value="">Select City</option>
                        @foreach ($this->listCities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                    <button wire:click="search" class="ml-4 px-6 py-2 text-white bg-green-500 rounded-md hover:bg-green-600 focus:ring focus:ring-green-300">
                        Search
                    </button>
                </div>
            </div>

            <div class="py-5 px-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">List of Halls</h2>

                @if(count($halls) > 0)
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                        @foreach ($halls as $hall)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800">
                                <img class="object-cover w-full h-48 rounded-t-lg" src="{{ asset('storage/' . $hall['diagram']) }}" alt="Hall Image" />
                                <div class="p-4">
                                    <h5 class="mb-2 text-xl font-semibold text-gray-900 dark:text-white">{{ $hall['name'] }}</h5>
                                    <p class="mb-3 text-sm text-gray-600 dark:text-gray-400">Capacity: {{ $hall['capacity'] }}</p>
                                    <a href="{{ route('halllist.show', $hall['id']) }}" class="inline-block px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:ring focus:ring-blue-300">
                                        Show Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="font-bold text-xl text-center mt-8">NO DATA</p>
                @endif
            </div>
        </div>
    </div>
</div>
