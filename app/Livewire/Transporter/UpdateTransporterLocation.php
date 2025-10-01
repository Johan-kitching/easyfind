<?php

namespace App\Livewire\Transporter;

use App\Models\Transporter;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class UpdateTransporterLocation extends Component
{
    use WireUiActions;

    public $address;
    public $city;
    public $address_latitude;
    public $address_longitude;
    public $transporters;
    public $listeners = ['confirmUpdateTransporter' => 'confirmUpdateTransporter', 'transporterTable'=>'$refresh'];

    public function mount()
    {

        $this->transporters = Auth()->user()->transporters;
    }

    public function render()
    {
        return view('transporter.update-transporter-location');
    }

    #[On('confirmUpdateTransporter')]
    public function confirmUpdateTransporter($id, $address, $city='', $lat, $long): void
    {
//        dump("Here");
        $this->address=$address;
        $this->city=$city;
        $this->address_latitude=$lat;
        $this->address_longitude=$long;
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Do you really want to change the location?',
            'acceptLabel' => 'Yes, update it',
            'method' => 'updateTransporter',
            'icon' => 'warning',
            'params' => ['id' => $id],
        ]);
    }

    #[On('updateTransporter')]
    public function updateTransporter($id): void
    {
        $transporter = Transporter::find($id)->first();
        $transporter->update([
            'address' => $this->address,
            'city' => $this->city,
            'address_latitude' => $this->address_latitude,
            'address_longitude' => $this->address_longitude
        ]);
        $this->dispatch('transporterTable');
        $this->dispatch('$refresh');
        $this->dispatch('TransporterDetails');
        $this->notification()->success(
            $title = 'Transporter',
            $description = 'Location updated to: ' . $this->address . '.'
        );
    }
}
