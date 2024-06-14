<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Halls;
use App\Models\City;

class HallList extends Component
{
    public $cities_id;
    public $selectedCity;
    public $selectedDate;
    public $halls;
    public function mount()
    {
        $this->halls = Halls::all();
        // $this->cities_id = $cities_id;
        // $this->halls = Halls::where('cities_id', $this->cityId)->get();
    }
    public function render()
    {
        return view('livewire.hall-list');
    }
    public function updatedHallList($halls)
    {
        $this->halls = $halls;
    }

    public function getListHallsProperty()
    {
        return Halls::all();
    }

    public function search()
    {
        $halls = Halls::query(); // Get the list of halls

        // Apply search filter
        if (!empty($this->selectedCity)) {
            $halls = $halls->where('cities_id', $this->selectedCity);
        }
        $this->halls = $halls->get();
        // return $halls;
    }
    
    public function getListCitiesProperty()
    {
        return City::all();
    }
}
