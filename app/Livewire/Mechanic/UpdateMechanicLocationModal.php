<?php

namespace App\Livewire\Mechanic;


use App\Models\Files;
use App\Models\Machinery;
use App\Models\Mechanic;
use App\Models\UserLocations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;
use LivewireUI\Modal\ModalComponent;

class UpdateMechanicLocationModal extends ModalComponent
{
    use WireUiActions, WithFileUploads;

    public $mechanic;
    public $address;
    public $city;
    public $address_latitude;
    public $address_longitude;
    public $rules = [
        'address' => ['required'],
        'city' => ['required'],
        'address_latitude' => ['required'],
        'address_longitude' => ['required'],
    ];
    public $listeners = ['MechanicDetails'];

    public function mount(Mechanic $mechanic, $address='', $city='', $address_latitude='', $address_longitude='')
    {
        $this->mechanic = $mechanic;
        $this->address = $address;
        $this->city = $city;
        $this->address_latitude = $address_latitude;
        $this->address_longitude = $address_longitude;
    }

    public function updated($fields): void
    {
        $this->validateOnly($fields);
    }

    public function save()
    {
//        dd($this->address, $this->city,$this->address_latitude, $this->address_longitude);
        $this->validate();

        $address = $this->address;
        $city = $this->city;
        $address_latitude = $this->address_latitude;
        $address_longitude = $this->address_longitude;

        $this->mechanic->update([
            'address' => $address,
            'city' => $city,
            'address_latitude' => $address_latitude,
            'address_longitude' => $address_longitude,
        ]);

        $this->notification()->success(
            $title = 'Mechanic',
            $description = 'Location updated to: ' . $this->address . '.'
        );
        $this->dispatch('mechanicTable');
        $this->dispatch('$refresh');
        $this->dispatch('MechanicDetails');
        $this->dispatch('closeModal');

    }

    public function render()
    {
        return view('mechanic.UpdateMechanicLocationModal');
    }
}
