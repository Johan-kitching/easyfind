<?php

namespace App\Livewire\Machinery;


use App\Models\Files;
use App\Models\Machinery;
use App\Models\MachineryType;
use App\Models\UserLocations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Laravel\Jetstream\Agent;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;
use LivewireUI\Modal\ModalComponent;

class View extends ModalComponent
{
    use WireUiActions, WithFileUploads;

    public Machinery $machinery;

    public $listeners = ['MachineryDetails'];

    public function mount(Machinery $machinery)
    {
        $this->machinery = $machinery;
        $agent=Request::server('HTTP_USER_AGENT');
        $ip=Request::ip();
        $this->machinery->views()->updateOrCreate([
            'user_agent'=>$agent,
            'ip'=>$ip
        ]);
    }

    public function render()
    {

        return view('machinery.view');
    }
}
