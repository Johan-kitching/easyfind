<?php

namespace App\Livewire;


use App\Models\Equipment;
use App\Models\Files;
use App\Models\Machinery;
use App\Models\MachineryAvailability;
use App\Models\MachineryType;
use App\Models\Mechanic;
use App\Models\Transporter;
use App\Models\UserLocations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;
use LivewireUI\Modal\ModalComponent;

class Availability extends ModalComponent
{
    use WireUiActions, WithFileUploads;

    public $subject;
    public $subjectId;
    public $item;
    public $startDate;
    public $endDate;
    public $rules = [
        'startDate' => ['required','date'],
        'endDate' => ['required','date','after:startDate'],
    ];
    public $listeners = ['Availability'];

    public function mount($subjectId, $subject)
    {
        $this->subject = $subject;
        $this->subjectId = $subjectId;
        if($subject == 'App\\Models\\Machinery'){
            $this->item = Machinery::find($subjectId);
        }elseif ($subject == 'App\\Models\\Transporter'){
            $this->item = Transporter::find($subjectId);
        }elseif ($subject == 'App\\Models\\Mechanic'){
            $this->item = Mechanic::find($subjectId);
        }elseif ($subject == 'App\\Models\\Equipment'){
            $this->item = Equipment::find($subjectId);
        }
//        dump($this->subjectId, $this->subject, $this->item);
    }

    public function updated($fields): void
    {
        $this->validateOnly($fields);
    }

    public function save()
    {
        $this->validate();
        $Availability = $this->item->availabilities()->create([
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ]);

        $this->notification()->success(
            $title = 'Availability',
            $description = 'Availability Updated.'
        );

        $this->dispatch('AvailabilityTable');
        $this->dispatch('$refresh');
        $this->dispatch('Availability');

//        $this->dispatch('closeModal');

    }


    public function render()
    {
        return view('availability');
    }
}
