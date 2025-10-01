<?php

namespace App\Livewire\Transporter;


use App\Models\Files;
use App\Models\Transporter;
use App\Models\TransporterType;
use App\Models\UserLocations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;
use LivewireUI\Modal\ModalComponent;

class Edit extends ModalComponent
{
    use WireUiActions, WithFileUploads;

    public $categories = [];
    public $category;
    public $types = [];
    public $type;
    public $models = [];
    public $model;
    public $locations = [];
    public $location;
    public $operators = [];
    public $operator;
    public $description;
    public $photos = [];
    public $photosLoaded = [];
    public $user;
    public $transporter;
    public $address;
    public $city;
    public $address_latitude;
    public $address_longitude;
    public $rules = [
        'type' => ['required'],
        'description' => ['required'],
    ];
    public $listeners = ['TransporterDetails'];

    public function mount(Transporter $transporter)
    {
        $this->user = Auth::user();
        $this->locations = Auth::user()->address()->get();
        $this->operators = Auth::user()->currentTeamMembers()->get();
        $this->type = $transporter->type->id;
        $this->types = TransporterType::all();
        $this->operator = $transporter->operator->id ?? null;
        $this->description = $transporter->description;
        $this->address = $transporter->address ?? 'none';
        $this->city = $transporter->city ?? 'none';
        $this->address_latitude = $transporter->address_latitude ?? 'none';
        $this->address_longitude = $transporter->address_longitude ?? 'none';
        $this->transporter = $transporter;
        $this->photosLoaded = $this->transporter->photos;
    }

    public function updated($fields): void
    {
        if ($fields == 'location') {
            $this->updatedAddress();
        }
    }

    public function updatedAddress(): void
    {
        $location = UserLocations::find($this->location);
        $this->address = $location->address ?? 'none';
        $this->city = $location->city ?? 'none';
        $this->address_latitude = $location->address_latitude ?? 'none';
        $this->address_longitude = $location->address_longitude ?? 'none';
    }

    public function save()
    {
        $this->resetErrorBag();
        if (count($this->photos) < 1 && count($this->photosLoaded) < 1) {
            return $this->addError('photos', 'Please upload at least 1 images');
        }
        $this->validate();

//        $address = null;
//        $city = null;
//        $address_latitude = null;
//        $address_longitude = null;

        if (!is_null($this->location)) {
            $location = UserLocations::find($this->location);
            $address = $location->address;
            $city = $location->city;
            $address_latitude = $location->address_latitude;
            $address_longitude = $location->address_longitude;
        }
        $this->transporter->update([
            'transporter_type_id' => $this->type,
            'user_id' => Auth::user()->id,
            'operator_id' => $this->operator ?? null,
            'description' => $this->description,
            'address' => $address ?? $this->transporter->address ?? null,
            'city' => $city ?? $this->transporter->city ?? null,
            'address_latitude' => $address_latitude ?? $this->transporter->address_latitude ?? null,
            'address_longitude' => $address_longitude ?? $this->transporter->address_longitude ?? null,
        ]);
        foreach ($this->photos as $image) {
            $filename = $image->getClientOriginalName();
            $name = md5($image . microtime()) . '.' . $image->extension();
            $folder = 'transporter/' . $this->transporter->id . '/photos/';
            File::makeDirectory($folder, 0775, true, true);
            $image->storeAs($folder, $name);
            Files::create(['path' => $name, 'filename' => $filename, 'file_type' => 'transporter', 'parental_type' => Transporter::class, 'parental_id' => $this->transporter->id]);
        }

        $this->dispatch('pondReset');
        $this->photosLoaded = $this->transporter->fresh();
        $this->notification()->success(
            $title = 'Transporter',
            $description = 'Transporter Updated.'
        );
        $this->dispatch('transporterTable');
        $this->dispatch('$refresh');
        $this->dispatch('TransporterDetails');

        $this->photosLoaded = $this->transporter->photos->fresh();
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
            $this->dispatch('TransporterDetails');
        }
        $this->notification()->success(
            $title = 'Transporter',
            $description = 'Image Removed From ' . $this->transporter->type->name . '.'
        );
    }

    public function render()
    {
        return view('transporter.edit');
    }
}
