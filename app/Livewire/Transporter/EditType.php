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

class EditType extends ModalComponent
{
    use WireUiActions, WithFileUploads;

    public $name;
    public $user;
    public $transporterType;
    public $rules = [
        'name' => ['required']
    ];

    public function mount(TransporterType $transporterType)
    {
        $this->transporterType = $transporterType;
        $this->user = Auth::user();
        $this->name = $transporterType->name;
    }

    public function save()
    {
        $data = $this->validate();

        $this->transporterType->update($data);

        $this->notification()->success(
            $title = 'Transporter',
            $description = 'Transporter Type Updated.'
        );
        $this->dispatch('transporterTypeTable');
        $this->dispatch('closeModal');

    }

    public function render()
    {
        return view('transporter.edit-type');
    }
}
