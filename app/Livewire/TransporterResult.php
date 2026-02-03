<?php

namespace App\Livewire;

use App\Models\Transporter;
use Livewire\Component;

use Livewire\Attributes\Reactive;

class TransporterResult extends Component
{

    #[Reactive]
    public Transporter $transporter;

    public function render()
    {
        $unavailable = $this->transporter->availabilities()
            ->whereRaw("`start_date` <= now() and `end_date` >= now()")
            ->get();
            
        return view('livewire.transporter-result', ['unavailable' => $unavailable]);
    }
}
