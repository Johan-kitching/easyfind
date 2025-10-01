<?php

namespace App\Livewire\Mechanic;

use App\Models\Mechanic;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class UpdateMechanicLocation extends Component
{
    use WireUiActions;

    public $address;
    public $city;
    public $address_latitude;
    public $address_longitude;
    public $mechanics;
    public $machine;
    public $listeners = ['confirmUpdateMechanic' => 'confirmUpdateMechanic', 'mechanicTable'=>'$refresh'];

    public function mount()
    {

        $this->mechanics = Auth()->user()->mechanics;
    }

    public function render()
    {
        return view('mechanic.update-mechanic-location');
    }

    #[On('confirmUpdateMechanic')]
    public function confirmUpdateMechanic($id, $address, $city='', $lat, $long): void
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
            'method' => 'updateMechanic',
            'icon' => 'warning',
            'params' => ['id' => $id],
        ]);
    }

    #[On('updateMechanic')]
    public function updateMechanic($id): void
    {
        $machine = Mechanic::find($id)->first();
        $machine->update([
            'address' => $this->address,
            'city' => $this->city,
            'address_latitude' => $this->address_latitude,
            'address_longitude' => $this->address_longitude
        ]);
        $this->dispatch('mechanicTable');
        $this->dispatch('$refresh');
        $this->dispatch('MechanicDetails');
        $this->notification()->success(
            $title = 'Mechanic',
            $description = 'Location updated to: ' . $this->address . '.'
        );
    }
}
