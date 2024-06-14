<?php

namespace App\Livewire;

use App\Models\City;
use App\Models\Halls;
use Livewire\Component;
use Illuminate\Support\Facades\Redirect;


class CitySelectionComponent extends Component
{
    public $selectedCity;


    public function mount()
    {
        $this->selectedCity = '';
    }

    public function render()
    {
        $cities = City::all();
        return view('livewire.city-selection-component', compact('cities'));
    }

    public function searchCities()
    {
        // Fetch halls related to the selected city
        $halls = Halls::where('city_id', $this->selectedCity)->get();

        // Emit an event to handle redirection in the parent component
        $this->emit('searchResults', $halls);

    }
}
