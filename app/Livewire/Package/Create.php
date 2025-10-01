<?php

namespace App\Livewire\Package;

use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    use WireUiActions, WithFileUploads;

    public $package;
    public $name;
    public $assets= 0;
    public $price;
    public $rules = [
        'name' => ['required'],
        'assets' => ['required','numeric'],
        'price' => ['required','numeric'],
    ];


    public function save()
    {
        $this->validate();
        $this->package = Package::create([
            'name' => $this->name,
            'assets' => $this->assets,
            'price' => $this->price,
            'user_id' => Auth::user()->id,
        ]);
        $this->notification()->success(
            $title = 'Package',
            $description = 'Package Created.'
        );
        $this->dispatch('PackageTable');
        $this->dispatch('closeModal');

    }

    public function render()
    {
        return view('package.create');
    }
}
