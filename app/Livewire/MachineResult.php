<?php

namespace App\Livewire;

use App\Models\Machinery;
use Livewire\Component;

class MachineResult extends Component
{

    public Machinery $machinery;
    public $unavailable;

    public function mount(Machinery $machinery)
    {
        $this->machinery = $machinery->loadMissing('photos');
        $this->unavailable = $machinery->availabilities()
            ->whereRaw("`start_date` <= now() and `end_date` >= now()")
            ->get();

    }
    public function render()
    {
//        dd($this->machinery);
        return view('livewire.machine-result');
    }
}
