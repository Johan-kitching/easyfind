<?php

namespace App\Livewire\Equipment;


use App\Models\Files;
use App\Models\Machinery;
use App\Models\EquipmentType;
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

    public $makes = [];
    public $model;
    public $categories = [];
    public $category;
    public $newCategory;
    public $types = [];
    public $type;
    public $newType;
    public $description;
    public $photos = [];
    public $user;
    public $machinery;
    public $rules = [
        'category' => ['required'],
        'type' => ['required'],
        'model' => ['required']
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->categories = EquipmentType::select('category')->groupBy('category')->get()->toArray();
        $this->types = EquipmentType::select('type')->groupBy('type')->get()->toArray();
        $this->model = '';
    }

    public function addCategory(): void
    {
        $this->categories[]=['category'=>$this->newCategory];
        $this->category = $this->newCategory;
        $this->newCategory = '';
    }

    public function addType(): void
    {
        $this->types[]=['type'=>$this->newType];
        $this->type = $this->newType;
        $this->newType = '';
    }

    public function save()
    {
        $data = $this->validate();

        $this->machinery = EquipmentType::create($data);

        $this->notification()->success(
            $title = 'Equipment',
            $description = 'Equipment Type Created.'
        );
        $this->dispatch('EquipmentTypeTable');
        $this->dispatch('closeModal');

    }

    public function render()
    {
        return view('equipment.create-type');
    }
}
