<?php

namespace App\Livewire\Admin\Users;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Laravel\Jetstream\Jetstream;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Role;
use WireUi\Traits\WireUiActions;

class CreateUser extends ModalComponent
{
    use WireUiActions;

    public User $user;
    public $memberName;
    public $number;
    public $status = 'active';
    public $companyName;
    public $companyContact;
    public $companyNumber;
    public $website;
    public $address;
    public $address_latitude;
    public $address_longitude;
    public $city;
    public $email;
    public $type = 'Personal';
    public $types;
    public $password;
    public $password_confirmation;
    public $terms;

    public function rules(): array
    {
        return [
            'memberName' => ['exclude_if:type,Company', 'required', 'string', 'max:255'],
            'number' => ['exclude_if:type,Company', 'required', 'string', 'max:255'],
            //company
            'companyName' => ['exclude_if:type,Personal', 'required', 'string', 'max:255'],
            'companyContact' => ['exclude_if:type,Personal', 'required', 'string', 'max:255'],
            'companyNumber' => ['exclude_if:type,Personal', 'required', 'string', 'max:255'],
            'website' => ['exclude_if:type,Personal', 'required', 'string', 'max:255'],
            //shared
            'address' => ['required', 'string'],
            'address_latitude' => ['required'],
            'address_longitude' => ['required'],
            'city' => ['required', 'string'],
            'type' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', Password::default(), 'confirmed'],
            'password_confirmation' => ['same:password'],
            'terms' => ['accepted', 'required']
        ];
    }


    public function mount()
    {

        if (Auth::user()->hasRole('Super Admin')) {
            $this->types = Role::all();
        } else {
            $this->types = Role::all()->where('name', '!=', 'Super Admin');
        }
    }

    public function save()
    {

        $this->validate();
        $this->user = User::create([
            'memberName' => $this->memberName,
            'number' => $this->number,
            'companyName' => $this->companyName,
            'address' => $this->address,
            'companyContact' => $this->companyContact,
            'companyNumber' => $this->companyNumber,
            'website' => $this->website,
            'type' => $this->type,
            'email' => $this->email,
            'terms' => $this->terms,
            'password' => Hash::make($this->password),
        ]);
        $this->user->address()->create([
            'name' => 'Main',
            'address' => $this->address,
            'address_latitude' => $this->address_latitude,
            'address_longitude' => $this->address_longitude,
            'city' => $this->city,
        ]);
        $this->user->assignRole('User');

        $this->notification()->success(
            $title = 'User saved',
            $description = 'User Created.'
        );
        $this->dispatch('userTable');
        $this->dispatch('closeModal');
    }

    public function updated($fields): void
    {
        $this->validateOnly($fields);
    }

    public function render()
    {
        return view('admin.users.create-user');
    }
}
