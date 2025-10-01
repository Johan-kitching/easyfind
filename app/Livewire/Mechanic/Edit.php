<?php

namespace App\Livewire\Mechanic;


use App\Models\Mechanic;
use App\Models\MechanicType;
use App\Models\UserLocations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;
use LivewireUI\Modal\ModalComponent;

class Edit extends ModalComponent
{
    use WireUiActions, WithFileUploads;

    public $name;
    public $description;
    public $mechanic;
    public $type;
    public $types;
    public $rules = [
        'name' => ['required'],
        'type' => ['required'],
        'description' => ['required'],
    ];

    public function mount(Mechanic $mechanic)
    {
        $this->name = $mechanic->name;
        $this->description = $mechanic->description;
        $this->mechanic = $mechanic;
        $this->type = $mechanic->type->id;
        $this->types = MechanicType::all();
    }

    public function save()
    {

        $this->validate();

        $this->mechanic->update([
            'name' => $this->name,
            'mechanic_type_id' => $this->type,
            'description' => $this->description,
        ]);

        $this->notification()->success(
            $title = 'Mechanic',
            $description = 'Mechanic Updated.'
        );
        $this->dispatch('mechanicTable');
        $this->dispatch('closeModal');

    }

    public function render()
    {
        return view('mechanic.edit');
    }
}
