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
            @livewire('sport-payment-detail', [
                'bookingId' => $rentalDetails['booking_id']
            ])
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Document loaded");
            const timerElement = document.getElementById('time');
            let startTime = localStorage.getItem('startTime');

            if (!startTime) {
                startTime = new Date().getTime();
                localStorage.setItem('startTime', startTime);
                console.log("Start time set:", startTime);
            } else {
                startTime = parseInt(startTime, 10);
                console.log("Start time retrieved:", startTime);
            }

            function updateTimer() {
                const currentTime = new Date().getTime();
                const elapsed = Math.floor((currentTime - startTime) / 1000);
                const remainingTime = 900 - elapsed;

                if (remainingTime <= 0) {
                    clearInterval(countdown);
                    localStorage.removeItem('startTime');
                    alert('Your session has expired. Please try again.');
                    window.location.href = '{{ route('dashboard') }}'; // Redirect to home or any other page
                    return;
                }

                const minutes = Math.floor(remainingTime / 60);
                let seconds = remainingTime % 60;
                seconds = seconds < 10 ? '0' + seconds : seconds;
                timerElement.innerHTML = `${minutes}:${seconds}`;
                console.log("Timer updated:", `${minutes}:${seconds}`);
            }

            const countdown = setInterval(updateTimer, 1000);
            updateTimer(); // Initial call to display the timer immediately
        });
    </script>
    @endpush
</x-app-layout>
