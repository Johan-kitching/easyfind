<?php

namespace App\Livewire\Profile;

use App\Models\User;
use App\Models\UserLocations;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class UpdateUserAddressInformation extends Component
{
    use WireUiActions;

    public User $user;
    public $address;
    public $address_latitude;
    public $address_longitude;
    public $city;
    public $rules = [
        'address' => ['required', 'string'],
        'address_latitude' => ['required'],
        'address_longitude' => ['required'],
        'city' => ['required', 'string'],
    ];

    public function mount(User $user)
    {
        $this->user = empty($user->id) ? Auth::user() : $user;
    }

    public function update(): void
    {
        $this->validate();

//        if($this->validate()->fail()){
//            $this->notification()->error(
//                $title = 'Update',
//                $description = 'Address Removed'
//            );
//        }
        $this->user->address()->create([
            'name' => $this->address,
            'address' => $this->address,
            'address_latitude' => $this->address_latitude,
            'address_longitude' => $this->address_longitude,
            'city' => $this->city,
        ]);
        $this->dispatch('AddressList')->to(AddressList::class);
//        $this->dispatch('$refresh')->to(AddressList::class);
        $this->notification()->success(
            $title = 'Update',
            $description = 'New Address Created.'
        );
        $this->dispatch('AddressList')->to(AddressList::class);
        $this->dispatch('reset');
//        dd($this->address,$this->address_latitude,$this->address_longitude,$this->city);
    }

    public function render()
    {
        return view('profile.update-profile-address-form');
    }
}
