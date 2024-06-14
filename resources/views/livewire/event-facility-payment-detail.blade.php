<div>
    <div class="py-6 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Section: User and Rental Information -->
                <div class="space-y-6">
                    <!-- User Information -->
                    <div class="space-y-2">
                        <h3 class="text-lg font-semibold mb-2">User Information</h3>
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                    </div>

                    <div class="space-y-2">
                        <h3 class="text-lg font-semibold mb-2">Rental Information</h3>
                        <p><strong>Event:</strong> {{ $event->name }}</p>
                        <p><strong>Date:</strong> {{ $rentalDetails['selectedDate'] }}</p>
                        
                        @if($rentalDetails['rentFacility'] === 'yes')
                            <h4 class="text-md font-semibold mt-2">Facilities</h4>
                            <ul class="list-disc list-inside">
                                @foreach($facilities as $facility)
                                    <li>{{ $facility->facility->name }} - Quantity: {{ $facility->quantity }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <p class="mt-4"><strong>Total Amount:</strong> RM{{ $rentalDetails['totalAmount'] }}</p>
                        <p class="text-gray-600 mt-2">RM200 deposit is included in the total amount.</p>
                    </div>
                </div>

                <!-- Right Section: Card Information -->
                <div class="space-y-6">
                    <h3 class="text-2xl font-semibold mb-4">Card Information</h3>

                    <form wire:submit.prevent="submitPayment" class="space-y-4">
                        @csrf
                        <div class="space-y-2">
                            <label for="cardName" class="block text-gray-700">Card Name:</label>
                            <input type="text" id="cardName" wire:model="cardName" class="w-full rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter card name" required>
                            @error('cardName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="space-y-2">
                            <label for="cardNum" class="block text-gray-700">Credit Card Number:</label>
                            <input type="text" id="cardNum" wire:model="cardNum" class="w-full rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="1111-2222-3333-4444" maxlength="19" required>
                            @error('cardNum') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="flex space-x-4">
                            <div class="w-full space-y-2">
                                <label for="expMonth" class="block text-gray-700">Exp Month:</label>
                                <select name="expMonth" id="expMonth" wire:model.defer="expMonth" class="w-full rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">Choose month</option>
                                    @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                        <option value="{{ $month }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                                @error('expMonth') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="w-full space-y-2">
                                <label for="expYear" class="block text-gray-700">Exp Year:</label>
                                <select name="expYear" id="expYear" wire:model="expYear" class="w-full rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">Choose year</option>
                                    @for ($i = 2025; $i <= now()->year + 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('expYear') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="cvv" class="block text-gray-700">CVV:</label>
                            <input type="text" id="cvv" wire:model="cvv" class="w-full rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="123" required>
                            @error('cvv') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-medium text-center rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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