<?php

namespace App\Livewire\Transporter;


use App\Models\Files;
use App\Models\Machinery;
use App\Models\MachineryType;
use App\Models\Transporter;
use App\Models\TransporterType;
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


    public $types = [];
    public $type;
    public $locations = [];
    public $location;
    public $operators = [];
    public $operator;
    public $description;
    public $photos = [];
    public $user;
    public $transporter;
    public $rules = [
        'type' => ['required'],
        'description' => ['required'],
        'photos' => ['required'],
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->locations = Auth::user()->address()->get();
        $this->operators = Auth::user()->currentTeamMembers()->get();
        $this->types = TransporterType::all();
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
        $this->transporter = Transporter::create([
            'transporter_type_id' => $this->type,
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
            $folder = 'transporter/' . $this->transporter->id . '/photos/';
            File::makeDirectory($folder, 0775, true, true);
            $image->storeAs($folder, $name);
            Files::create(['path' => $name, 'filename' => $filename, 'file_type' => 'transporter', 'parental_type' => Transporter::class, 'parental_id' => $this->transporter->id]);
        }
        $this->notification()->success(
            $title = 'Transporter',
            $description = 'Transporter Created.'
        );
        $this->dispatch('transporterTable');
        $this->dispatch('closeModal');

    }

    public function render()
    {
        return view('transporter.create');
    }
}
