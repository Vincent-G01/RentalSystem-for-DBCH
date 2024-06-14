<?php

namespace App\Livewire;

use App\Models\Halls;
use Livewire\Component;

class DetailHall extends Component
{
    public $halls;
    // public $diagram;
    public $selectedHall;

    public function mount(){
        $this -> halls = Halls::all();
    }


    
    // public function render()
    // {
    //     // Fetch the selected hall's details
    //     $hall = Halls::find($this->selectedHall);

    //     return view('livewire.detail-hall', [
    //         'hall' => $hall,
    //     ]);
    // }



    // public function render()
    // {
    //     $hall = Halls::with(['courtRentals', 'eventFacilityRentals.event', 'eventFacilityRentals.facility'])->find($this->selectedHall);
    
    //     return view('livewire.detail-hall', [
    //         'hall' => $hall,
    //     ]);
    // }

    public function render()
    {
        $hall = Halls::with(['courtRentals', 'eventFacilityRentals'])->find($this->selectedHall);
    
        return view('livewire.detail-hall', [
            'hall' => $hall,
        ]);
    }
    

}

