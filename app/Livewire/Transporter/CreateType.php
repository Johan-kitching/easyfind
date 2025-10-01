<?php

namespace App\Livewire\Transporter;


use App\Models\Files;
use App\Models\Machinery;
use App\Models\MachineryType;
use App\Models\TransporterType;
use App\Models\UserLocations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;
use LivewireUI\Modal\ModalComponent;

class CreateType extends ModalComponent
{
    use WireUiActions, WithFileUploads;


    public $name;
    public $user;
    public $transporterType;
    public $rules = [
        'name' => ['required']
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->name = '';
    }

    public function save()
    {
        $data = $this->validate();

        $this->transporterType = TransporterType::create($data);
        $this->name = '';

        $this->notification()->success(
            $title = 'Transporter',
            $description = 'Transporter Type Created.'
        );
        $this->dispatch('transporterTypeTable');
        $this->dispatch('closeModal');

    }

    public function render()
    {
        return view('transporter.create-type');
    }
}
