{{-- <div class="mb-4">
    <label for="datePicker" class="block text-sm font-medium text-gray-700">Select Date</label>
    <input
        type="text"
        id="datePicker"
        x-data
        x-init="
            flatpickr($refs.datePicker, { 
                dateFormat: 'Y-m-d', 
                minDate: 'today',
                onChange: function(selectedDates){ 
                    @this.set('selectedDate', selectedDates[0].toISOString().split('T')[0]);
                } 
            })
        "
        wire:model="selectedDate"
        class="mt-1 p-2 border rounded-md w-full"
        autocomplete="off"
        x-ref="datePicker"
    >
</div>

@livewireScripts --}}