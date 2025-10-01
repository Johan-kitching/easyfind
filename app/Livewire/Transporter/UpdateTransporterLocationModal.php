<?php

namespace App\Livewire\Transporter;


use App\Models\Files;
use App\Models\Machinery;
use App\Models\Transporter;
use App\Models\UserLocations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;
use LivewireUI\Modal\ModalComponent;

class UpdateTransporterLocationModal extends ModalComponent
{
    use WireUiActions, WithFileUploads;

    public $transporter;
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
    public $listeners = ['TransporterDetails'];

    public function mount(Transporter $transporter, $address='', $city='', $address_latitude='', $address_longitude='')
    {
        $this->transporter = $transporter;
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

        $this->transporter->update([
            'address' => $address,
            'city' => $city,
            'address_latitude' => $address_latitude,
            'address_longitude' => $address_longitude,
        ]);

        $this->notification()->success(
            $title = 'Transporter',
            $description = 'Location updated to: ' . $this->address . '.'
        );
        $this->dispatch('transporterTable');
        $this->dispatch('$refresh');
        $this->dispatch('TransporterDetails');
        $this->dispatch('closeModal');

    }

    public function render()
    {
        return view('transporter.UpdateTransporterLocationModal');
    }
}
