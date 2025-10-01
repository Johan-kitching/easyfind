<?php

namespace App\Livewire\Transporter;


use App\Models\Files;
use App\Models\Machinery;
use App\Models\MachineryType;
use App\Models\Transporter;
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

    public $transporter;

    public $listeners = ['MachineryDetails'];

    public function mount($transporter)
    {
        $this->transporter = Transporter::find($transporter);
        $agent=Request::server('HTTP_USER_AGENT');
        $ip=Request::ip();
        $this->transporter->views()->updateOrCreate([
            'user_agent'=>$agent,
            'ip'=>$ip
        ]);
    }

    public function render()
    {

        return view('transporter.view');
    }
}
