{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rent now!
        </h2>
    </x-slot>

    <link href="{{ asset('css/fullcalendar/core/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fullcalendar/daygrid/main.css') }}" rel="stylesheet">

    <div class="container mx-auto mt-5">
        @livewire('booking-list', ['hall' => $hall])
    </div>

    {{-- <div id="calendar"></div> --}}

    {{-- <script src="{{ asset('js/fullcalendar/core/main.js') }}"></script>
    <script src="{{ asset('js/fullcalendar/daygrid/main.js') }}"></script>
    <script src="{{ asset('js/fullcalendar/interaction/main.js') }}"></script> --}}

    {{-- <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('updateCalendar', function (events) {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: events, // Update events data when Livewire event is triggered
                    // Add other FullCalendar options as needed
                });
                calendar.render();
            });
        });
    </script> --}}

    {{-- @livewireScripts
</x-app-layout>
 --}} 
