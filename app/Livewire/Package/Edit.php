<?php

namespace App\Livewire\Package;

use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;
use LivewireUI\Modal\ModalComponent;

class Edit extends ModalComponent
{
    use WireUiActions, WithFileUploads;

    public $package;
    public $name;
    public $assets = 0;
    public $price;
    public $rules = [
        'name' => ['required'],
        'assets' => ['required', 'numeric'],
        'price' => ['required', 'numeric'],
    ];

    public function mount(Package $package)
    {
        $this->package = $package;
        $this->name = $package->name;
        $this->assets = $package->assets;
        $this->price = $package->price;
    }

    public function save()
    {

        $this->validate();

        $this->package->update([
            'name' => $this->name,
            'assets' => $this->assets,
            'price' => $this->price,
            'user_id' => Auth::user()->id,
        ]);

        $this->notification()->success(
            $title = 'Package',
            $description = 'Package Updated.'
        );
        $this->dispatch('PackageTable');
        $this->dispatch('closeModal');

    }

    public function render()
    {
        return view('package.edit');
    }
}
