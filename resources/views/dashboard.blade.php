<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <!-- Uncomment the following line to include the hall-list component -->
    @livewire('hall-list')

    @push('scripts')
        <script>
            document.addEventListener('livewire:load', function () {
                Livewire.on('searchResults', function (halls) {
                    // Redirect to halllist route with halls data
                    window.location.href = "{{ route('halllist') }}" + '?halls=' + encodeURIComponent(JSON.stringify(halls));
                });
            });
        </script>
    @endpush
</x-app-layout>

