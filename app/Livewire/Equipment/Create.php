<?php

namespace App\Livewire\Equipment;


use App\Models\Equipment;
use App\Models\Files;
use App\Models\User;
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

    public $makes = [];
    public $make;
    public $variants = [];
    public $variant;
    public $locations = [];
    public $location;
    public $operators = [];
    public $operator;
    public $description;
    public $photos = [];
    public $user;
    public $equipment;
    public $rules = [
        'make' => ['required'],
        'variant' => ['required'],
        'description' => ['required'],
        'photos' => ['required'],
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->locations = Auth::user()->address()->get();
        $this->operators = Auth::user()->currentTeamMembers()->get()->fresh();
        $this->makes = DB::table('codes_and_descriptions')->whereIn('vehicle_type', ['H', 'T'])->select('make', DB::raw('MIN(id) as id'))->groupBy('make')->get();
        $this->make = '';
//        dd($this->makes);
    }

    public function updated($fields): void
    {
        if ($fields == 'make') {
            $this->variants = DB::table('codes_and_descriptions')
                ->select('variant', DB::raw('MIN(id) as id'))
                ->where('make', $this->make)
                ->whereIn('vehicle_type', ['H', 'T'])
                ->groupBy('variant')
                ->get();
        }
        $this->validateOnly($fields);
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
        $this->equipment = Equipment::create([
            'codes_and_descriptions_id' => $this->variant,
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
            $name = md5($image . microtime()) . '.' . $image->extension();
            $folder = 'equipment/' . $this->equipment->id . '/photos/';
            File::makeDirectory($folder, 0775, true, true);
            $image->storeAs($folder, $name);
            Files::create(['path' => $name, 'filename' => $filename, 'file_type' => 'equipment', 'parental_type' => Equipment::class, 'parental_id' => $this->equipment->id]);
            $this->notification()->success(
                $title = 'Equipment',
                $description = 'Equipment Created.'
            );
        }
    }

    public function render()
    {
        return view('equipment.create');
    }
}
