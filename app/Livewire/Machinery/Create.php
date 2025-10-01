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

class Create extends ModalComponent
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
    public $user;
    public $machinery;
    public $rules = [
        'type' => ['required'],
        'description' => ['required'],
        'photos' => ['required'],
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->locations = Auth::user()->address()->get();
        $this->operators = Auth::user()->currentTeamMembers()->get()->fresh();
        $this->category = "Attachments";
        $this->categories = $this->getCategories();
        $this->types = $this->getTypes();
//        dump($this->operators);
    }

    public function updated($fields): void
    {
        if ($fields == 'category') {
            $this->type = '';
            $this->types = $this->getTypes();
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

    public function save()
    {
        $this->validate();

        $address = null;
        $city = null;
        $address_latitude = null;
        $address_longitude = null;

        if (!is_null($this->location)) {
            $location = UserLocations::find($this->location);
            $address = $location->address;
            $city = $location->city;
            $address_latitude = $location->address_latitude;
            $address_longitude = $location->address_longitude;
        }
        $this->machinery = Machinery::create([
            'machinery_type_id' => $this->type,
            'user_id' => Auth::user()->id,
            'operator_id' => $this->operator,
            'description' => $this->description,
            'address' => $address,
            'city' => $city,
            'address_latitude' => $address_latitude,
            'address_longitude' => $address_longitude,
        ]);
        foreach ($this->photos as $image) {
            $filename = $image->getClientOriginalName();
//            $filename = $image->resize();
            $name = md5($image . microtime()) . '.' . $image->extension();
            $folder = 'machinery/' . $this->machinery->id . '/photos/';
            File::makeDirectory($folder, 0775, true, true);
            $image->storeAs($folder, $name);
            Files::create(['path' => $name, 'filename' => $filename, 'file_type' => 'machinery', 'parental_type' => Machinery::class, 'parental_id' => $this->machinery->id]);

        }
        $this->notification()->success(
            $title = 'Machinery',
            $description = 'Machinery Created.'
        );
        $this->dispatch('machineryTable');
        $this->dispatch('closeModal');

    }

    public function render()
    {
        return view('machinery.create');
    }
}
