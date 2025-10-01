<?php

namespace App\Livewire\Mechanic;



use App\Models\Mechanic;
use App\Models\MechanicType;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
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

    public function mount()
    {
        $this->types = MechanicType::all();
    }

    public function save()
    {
        $this->validate();
        $this->mechanic = Mechanic::create([
            'name' => $this->name,
            'mechanic_type_id' => $this->type,
            'description' => $this->description,
            'user_id' => Auth::user()->id,
        ]);
        $this->notification()->success(
            $title = 'Mechanic',
            $description = 'Mechanic Created.'
        );
        $this->dispatch('mechanicTable');
        $this->dispatch('closeModal');

    }

    public function render()
    {
        return view('mechanic.create');
    }
}
