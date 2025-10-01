<?php

namespace App\Livewire;

use App\Models\Transporter;
use Livewire\Component;

class TransporterResult extends Component
{

    public $transporter;
    public $distance;
    public $unavailable;

    public function mount($transporter, $distance): void
    {
        $this->transporter = Transporter::find($transporter);
        $this->distance = $distance;
        $this->unavailable = $this->transporter->availabilities()
            ->whereRaw("`start_date` <= now() and `end_date` >= now()")
            ->get();
//        dump($this->transporter->type);

    }
    public function render()
    {
//        dd($this->transporter);
        return view('livewire.transporter-result');
    }
}
