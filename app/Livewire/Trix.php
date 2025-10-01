<?php

namespace App\Livewire;

use Livewire\Component;

class Trix extends Component
{

    public $value;
    public $trixId;
    public $event;
    const EVENT_VALUE_UPDATED = 'trix_value_updated';

    public function mount($value = '', $event = null)
    {
        $this->value = $value;
        $this->trixId = 'trix' . uniqid();
        $this->event = $event;
    }

    public function updatedValue($value)
    {
        if($this->event) {
            $this->dispatch($this->event, $this->value);
        }else{
            $this->dispatch(self::EVENT_VALUE_UPDATED, $this->value);
        }
    }

    public function render()
    {
        return view('trix');
    }
}
