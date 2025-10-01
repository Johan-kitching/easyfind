<?php

namespace App\Livewire;

use App\Models\Mechanic;
use Livewire\Component;

class MechanicResult extends Component
{

    public $mechanic;
    public $distance;
    public $unavailable;

    public function mount($mechanic, $distance): void
    {
        $this->mechanic = Mechanic::find($mechanic);
        $this->distance = $distance;
        $this->unavailable = $this->mechanic->availabilities()
            ->whereRaw("`start_date` <= now() and `end_date` >= now()")
            ->get();
    }
    public function render()
    {
        return view('livewire.mechanic-result');
    }
}
