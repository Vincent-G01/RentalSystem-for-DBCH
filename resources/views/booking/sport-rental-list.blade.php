<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rent Sport now!
        </h2>
    </x-slot>

    @livewire('sport-rental', ['selectedHall' => $hall->id])

    {{-- <livewire:sport-booking-confirmation-modal :rentalInfo="$rentalInfo" /> --}}

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script> --}}
</x-app-layout>

