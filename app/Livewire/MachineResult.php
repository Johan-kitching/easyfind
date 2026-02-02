<?php

namespace App\Livewire;

use App\Models\Machinery;
use Livewire\Component;

use Livewire\Attributes\Reactive;

class MachineResult extends Component
{

    #[Reactive]
    public Machinery $machinery;

    public function render()
    {
        $unavailable = $this->machinery->availabilities()
            ->whereRaw("`start_date` <= now() and `end_date` >= now()")
            ->get();

        return view('livewire.machine-result', [
            'unavailable' => $unavailable
        ]);
    }
}
