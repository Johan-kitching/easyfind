<?php

namespace App\Livewire;

use App\Models\Mechanic;
use Livewire\Component;

use Livewire\Attributes\Reactive;

class MechanicResult extends Component
{

    #[Reactive]
    public Mechanic $mechanic;

    public function render()
    {
        $unavailable = $this->mechanic->availabilities()
            ->whereRaw("`start_date` <= now() and `end_date` >= now()")
            ->get();
            
        return view('livewire.mechanic-result', ['unavailable' => $unavailable]);
    }
}
