<?php

// HallListController.php

namespace App\Http\Controllers;

use livewire\Livewire;
use App\Models\Halls;

use Illuminate\Http\Request;

class HallListController extends Controller
{
    public function show(Request $request, $id)
    {
        $hall =  Halls::find((int)$id);
        return view('halls/detail', [
            'hall'=>$hall,
        ]);
    }

    
}
