<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Payment Information
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div id="timer" class="text-red-500 font-bold text-xl mb-4">
                You have <span id="time">15:00</span> minutes to complete your transaction.
            </div>
            <div>
                @livewire('event-facility-payment-detail', ['bookingId' => $rentalDetails['bookingId']])
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const timerElement = document.getElementById('time');
                let startTime = localStorage.getItem('startTime');

                if (!startTime) {
                    startTime = new Date().getTime();
                    localStorage.setItem('startTime', startTime);
                }

                function updateTimer() {
                    const now = new Date().getTime();
                    const distance = now - startTime;
                    const totalSeconds = Math.floor(distance / 1000);
                    const minutes = Math.floor((15 * 60 - totalSeconds) / 60);
                    const seconds = (15 * 60 - totalSeconds) % 60;

                    if (minutes <= 0 && seconds <= 0) {
                        timerElement.innerHTML = "00:00";
                        localStorage.removeItem('startTime');
                        alert("Your session has expired!");
                        location.reload();
                    } else {
                        timerElement.innerHTML = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    }
                }

                setInterval(updateTimer, 1000);
            });
        </script>
    @endpush
</x-app-layout>