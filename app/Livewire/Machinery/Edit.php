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
    public $machinery;
    public $address;
    public $city;
    public $address_latitude;
    public $address_longitude;
    public $rules = [
        'type' => ['required'],
        'description' => ['required'],
    ];
    public $listeners = ['MachineryDetails'];

    public function mount(Machinery $machinery)
    {
        $this->user = Auth::user();
        $this->locations = Auth::user()->address()->get();
        $this->operators = Auth::user()->currentTeamMembers()->get()->fresh();
        $this->category = $machinery->type->category;
        $this->type = $machinery->machinery_type_id;
        $this->model = $machinery->type->id;
        $this->categories = $this->getCategories();
        $this->types = $this->getTypes();
        $this->operator = $machinery->operator->id ?? null;
        $this->description = $machinery->description;
        $this->address = $machinery->address ?? 'none';
        $this->city = $machinery->city ?? 'none';
        $this->address_latitude = $machinery->address_latitude ?? 'none';
        $this->address_longitude = $machinery->address_longitude ?? 'none';
        $this->machinery = $machinery;
        $this->photosLoaded = $this->machinery->photos;
    }

    public function updated($fields): void
    {
        if ($fields == 'category') {
//            $this->type = '';
            $this->types = $this->getTypes();
        }

        if ($fields == 'location') {
            $this->updatedAddress();
        }

    }

    public function getCategories(): array
    {
        return MachineryType::select('category')->groupBy('category')->get()->toArray();
    }

    public function getTypes(): array
    {
        return MachineryType::select(['id','type'])->where('category', $this->category)->get()->toArray();
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
        $this->machinery->update([
            'machinery_type_id' => $this->type,
            'user_id' => Auth::user()->id,
            'operator_id' => $this->operator ?? null,
            'description' => $this->description,
            'address' => $address ?? $this->machinery->address ?? null,
            'city' => $city ?? $this->machinery->city ?? null,
            'address_latitude' => $address_latitude ?? $this->machinery->address_latitude ?? null,
            'address_longitude' => $address_longitude ?? $this->machinery->address_longitude ?? null,
        ]);
        foreach ($this->photos as $image) {
            $filename = $image->getClientOriginalName();
            $name = md5($image . microtime()) . '.' . $image->extension();
            $folder = 'machinery/' . $this->machinery->id . '/photos/';
            File::makeDirectory($folder, 0775, true, true);
            $image->storeAs($folder, $name);
            Files::create(['path' => $name, 'filename' => $filename, 'file_type' => 'machinery', 'parental_type' => Machinery::class, 'parental_id' => $this->machinery->id]);
        }

        $this->dispatch('pondReset');
        $this->photosLoaded = $this->machinery->fresh();
        $this->notification()->success(
            $title = 'Machinery',
            $description = 'Machinery Updated.'
        );
        $this->dispatch('machineryTable');
        $this->dispatch('$refresh');
        $this->dispatch('MachineryDetails');

        $this->photosLoaded = $this->machinery->photos->fresh();
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
            $description = 'Image Removed From ' . $this->machinery->type->type . '.'
        );
    }

    public function render()
    {
        return view('machinery.edit');
    }
}
