<?php

namespace App\Livewire\Machinery;


use App\Models\Files;
use App\Models\Machinery;
use App\Models\MachineryAvailability;
use App\Models\MachineryType;
use App\Models\UserLocations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;
use LivewireUI\Modal\ModalComponent;

class Availability extends ModalComponent
{
    use WireUiActions, WithFileUploads;

    public $machinery;
    public $startDate;
    public $endDate;
    public $rules = [
        'startDate' => ['required','date'],
        'endDate' => ['required','date'],
    ];
    public $listeners = ['MachineryAvailability'];

    public function mount(Machinery $machinery)
    {
        $this->machinery = $machinery;
    }

    public function updated($fields): void
    {
        $this->validateOnly($fields);
    }

    public function save()
    {
        $this->validate();
        $machineryAvailability = $this->machinery->availabilities()->create([
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ]);

        $this->notification()->success(
            $title = 'Machinery',
            $description = 'Machinery Updated.'
        );

        $this->dispatch('machineryTable');
        $this->dispatch('$refresh');
        $this->dispatch('MachineryDetails');

        $this->dispatch('closeModal');

    }

    public function confirmRemove($id): void
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Do you really want to remove this image?',
            'acceptLabel' => 'Yes, remove it',
            'method' => 'removeImage',
            'icon' => 'warning',
            'params' => ['id' => $id],
        ]);
    }

    public function removeImage($info): void
    {
        $file = FILES::find($info['id']);
        $location = storage_path("../" . $file->fullPath);
        if (File::exists($location)) {
            $file->delete();
            File::delete($location);
            $this->dispatch('$refresh');
            $this->dispatch('MachineryDetails');
        }
        $this->notification()->success(
            $title = 'Machinery',
            $description = 'Image Removed From ' . $this->machinery->codesAndDescriptions->variant . '.'
        );
    }

    public function render()
    {
        return view('machinery.availability');
    }
}
