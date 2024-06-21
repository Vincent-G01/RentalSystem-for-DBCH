<div>
    <div class="py-6 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Section: User and Rental Information -->
                <div>
                    <!-- User Information -->
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold mb-2">User Information</h3>
                        <p><strong>Name:</strong> {{ $userName }}</p>
                        <p><strong>Email:</strong> {{ $userEmail }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-2xl font-semibold mb-4">Rental Information</h3>
                        <p class="mb-2"><strong>Sport:</strong> {{ $sportName ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Date:</strong> {{ $rentalDetails['date'] ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Time Slots:</strong></p>
                        <ul class="mb-2">
                            @isset($rentalDetails['selectedTimes'])
                                @foreach ($rentalDetails['selectedTimes'] as $court => $timeSlots)
                                    @foreach ($timeSlots as $timeSlot)
                                        <li>{{ $court }}: {{ $timeSlot['time'] }}</li>
                                    @endforeach
                                @endforeach
                            @endisset
                        </ul>
                        
                        <p class="mb-2"><strong>Total Amount:</strong> RM{{ number_format($rentalDetails['totalAmount'] ?? 0, 2) }}</p>
                    </div>
                </div>

                <!-- Right Section: Card Information -->
                <div>
                    <h3 class="text-2xl font-semibold mb-4">Card Information</h3>

                    <form wire:submit.prevent="submitPayment" class="flex flex-col space-y-4">
                        @csrf
                    
                        <div class="flex flex-col space-y-2">
                            <label for="cardName" class="text-gray-700">Card Name:</label>
                            <input type="text" id="cardName" wire:model="cardName" class="rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter card name" required>
                            @error('cardName') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    
                        <div class="flex flex-col space-y-2">
                            <label for="cardNum" class="text-gray-700">Credit Card Number:</label>
                            <input type="text" id="cardNum" wire:model="cardNum" class="rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="1111-2222-3333-4444" maxlength="19" required>
                            @error('cardNum') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    
                        <div class="flex space-x-4">
                            <div class="w-full">
                                <label for="expMonth" class="text-gray-700">Exp Month:</label>
                                <select name="expMonth" id="expMonth" wire:model.defer="expMonth" class="rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">Choose month</option>
                                    @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                        <option value="{{ $month }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                                @error('expMonth') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                    
                            <div class="w-full">
                                <label for="expYear" class="text-gray-700">Exp Year:</label>
                                <select name="expYear" id="expYear" wire:model="expYear" class="rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">Choose year</option>
                                    @for ($i = 2025; $i <= now()->year + 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('expYear') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    
                        <div class="flex flex-col space-y-2">
                            <label for="cvv" class="text-gray-700">CVV:</label>
                            <input type="text" id="cvv" wire:model="cvv" class="rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="123" required>
                            @error('cvv') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    
                        <button type="submit" class="w-full mt-4 py-2 px-4 bg-indigo-600 text-white font-medium text-center rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Submit Payment
                        </button>
                    </form>
                </div>
            </div>

            <!-- Success and Error Messages -->
            @if (session('success'))
                <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let cardNumInput = document.querySelector('#cardNum');
        cardNumInput.addEventListener('keyup', () => {
            let cNumber = cardNumInput.value.replace(/\s/g, "");
            if (!isNaN(cNumber)) {
                cNumber = cNumber.match(/.{1,4}/g).join(" ");
            } else {
                cNumber = cNumber.slice(0, -1);
            }
            cardNumInput.value = cNumber;
        });
    });
</script>
@endpush

