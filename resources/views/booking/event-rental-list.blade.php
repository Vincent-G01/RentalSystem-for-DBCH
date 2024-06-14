<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rent Event Now!
        </h2>
    </x-slot>

    @livewire('event-rental', ['selectedHall' => $hall->id])

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</x-app-layout>