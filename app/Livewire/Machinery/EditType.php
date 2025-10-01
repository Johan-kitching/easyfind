<?php

namespace App\Livewire\Machinery;


use App\Models\Files;
use App\Models\Machinery;
use App\Models\MachineryType;
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

    public $makes = [];
    public $model;
    public $categories = [];
    public $category;
    public $newCategory;
    public $types = [];
    public $type;
    public $newType;
    public $machineryType;
    public $user;
    public $rules = [
        'category' => ['required'],
        'type' => ['required'],
    ];

    public function mount(MachineryType $machineryType)
    {
        $this->machineryType = $machineryType;
        $this->user = Auth::user();
        $this->categories = MachineryType::select('category')->groupBy('category')->get()->toArray();
        $this->category = $machineryType->category;
        $this->types = MachineryType::select('type')->groupBy('type')->get()->toArray();
        $this->type = $machineryType->type;
        $this->model = $machineryType->model;
    }

    public function addCategory(): void
    {
        $this->categories[] = ['category' => $this->newCategory];
        $this->category = $this->newCategory;
        $this->newCategory = '';
    }

    public function addType(): void
    {
        $this->types[] = ['type' => $this->newType];
        $this->type = $this->newType;
        $this->newType = '';
    }

    public function save()
    {
        $data = $this->validate();

        $this->machineryType->update($data);

        $this->notification()->success(
            $title = 'Machinery',
            $description = 'Machinery Type Updated.'
        );
        $this->dispatch('machineryTypeTable');
        $this->dispatch('closeModal');

    }

    public function render()
    {
        return view('machinery.edit-type');
    }
}
