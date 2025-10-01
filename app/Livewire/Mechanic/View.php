<?php

namespace App\Livewire\Mechanic;


use App\Models\Files;
use App\Models\Machinery;
use App\Models\MachineryType;
use App\Models\Mechanic;
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

    public Mechanic $mechanic;

    public $listeners = ['MechanicDetails'];

    public function mount(Mechanic $mechanic)
    {
        $this->mechanic= $mechanic;
        $agent=Request::server('HTTP_USER_AGENT');
        $ip=Request::ip();
        $this->mechanic->views()->updateOrCreate([
            'user_agent'=>$agent,
            'ip'=>$ip
        ]);
    }

    public function render()
    {

        return view('mechanic.view');
    }
}
