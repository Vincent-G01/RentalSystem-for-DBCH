{{-- no use --}}

<div>
    <label for="city">Select City:</label>
    <select wire:model="selectedCity" id="city" class="form-select">
      <option value="">Select...</option>
      @foreach ($cities as $city)
        <option value="{{ $city->id }}">{{ $city->name }}</option>
      @endforeach
    </select>
    {{-- <button wire:click="searchCities" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Search</button> --}}
</div>


<script>
    document.addEventListener('livewire:load', () => {
        Livewire.on('cityUpdated', (city) => {
            const selectedCityId = city.id;
            fetchHalls(selectedCityId);
        });
    });

    function fetchHalls(selectedCityId) {
        fetch(`/api/cities/${selectedCityId}/halls`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const resultsDiv = document.getElementById('search-results');
                resultsDiv.innerHTML = generateHallsList(data);
            })
            .catch(error => {
                console.error(error);
                // Handle any errors during data fetching
            });
    }

    function generateHallsList(data) {
        // Implement logic to generate HTML for halls list based on retrieved data
    }
</script>