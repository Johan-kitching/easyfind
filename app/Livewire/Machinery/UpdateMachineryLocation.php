<?php

namespace App\Livewire\Machinery;

use App\Models\Machinery;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class UpdateMachineryLocation extends Component
{
    use WireUiActions;

    public $address;
    public $city;
    public $address_latitude;
    public $address_longitude;
    public $machines;
    public $machine;
    public $listeners = ['confirmUpdateMachinery' => 'confirmUpdateMachinery', 'machineryTable'=>'$refresh'];

    public function mount()
    {

        $this->machines = Auth()->user()->machinery;
    }

    public function render()
    {
        return view('machinery.update-machinery-location');
    }

    #[On('confirmUpdateMachinery')]
    public function confirmUpdateMachinery($id, $address, $city='', $lat, $long): void
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
            'method' => 'updateMachinery',
            'icon' => 'warning',
            'params' => ['id' => $id],
        ]);
    }

    #[On('updateMachinery')]
    public function updateMachinery($id): void
    {
        $machine = Machinery::find($id)->first();
        $machine->update([
            'address' => $this->address,
            'city' => $this->city,
            'address_latitude' => $this->address_latitude,
            'address_longitude' => $this->address_longitude
        ]);
        $this->dispatch('machineryTable');
        $this->dispatch('$refresh');
        $this->dispatch('MachineryDetails');
        $this->notification()->success(
            $title = 'Machinery',
            $description = 'Location updated to: ' . $this->address . '.'
        );
    }
}
