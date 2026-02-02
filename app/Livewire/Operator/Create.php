<?php

namespace App\Livewire\Operator;

use AllowDynamicProperties;
use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Equipment;
use App\Models\Machinery;
use App\Models\Transporter;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use WireUi\Traits\WireUiActions;
use LivewireUI\Modal\ModalComponent;

#[AllowDynamicProperties] class Create extends ModalComponent
{
    use WireUiActions, PasswordValidationRules;

    public $current_team_id;
    public $equipments = [];
    public $equipment = [];
    public $transporters = [];
    public $transporter = [];
    public $password;
    public $password_confirmation;
    public $name;
    public $number;
    public $email;
    public $type;
    public $user;

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'password_confirmation' => ['same:password'],
        ];
    }

    public function mount()
    {
        $this->current_team_id = Auth::user()->id;
        $this->equipments = DB::table('machineries')
            ->join('machinery_types', 'machineries.machinery_type_id', 'machinery_types.id')
            ->selectRaw("concat_ws(' ', machineries.id, '-', machinery_types.category, '-', machinery_types.type) as variant, machineries.id")
            ->where('machineries.user_id', $this->current_team_id)
            ->get();
        $this->transporters = DB::table('transporters')
            ->join('transporter_types', 'transporters.transporter_type_id', 'transporter_types.id')
            ->selectRaw("concat_ws(' ', transporters.id, '-', transporter_types.name, '-', transporters.description) as variant, transporters.id")
            ->where('transporters.user_id', $this->current_team_id)
            ->get();
        $this->type = 'Operator';
    }

    public function updated($fields): void
    {
        $this->validateOnly($fields);
    }

    public function save(){
        $this->validate();
        $this->user = User::create([
            'MemberName' => $this->name,
            'name' => $this->name,
            'number' => $this->number,
            'current_team_id' => Auth::user()->id,
            'companyName' => Auth::user()->companyName,
            'companyContact' => Auth::user()->companyContact,
            'companyNumber' => Auth::user()->companyNumber,
            'website' => Auth::user()->website,
            'type' => $this->type,
            'email' => $this->email,
            'terms' => 'on',
            'password' => Hash::make($this->password),
        ]);
        if(!empty($this->equipment)){
            foreach ($this->equipment as $equipment){
                Machinery::find($equipment)->first()->update(['operator_id'=>$this->user->id]);
            }
        }
        if(!empty($this->transporter)){
            foreach ($this->transporter as $transporter){
                Transporter::find($transporter)->first()->update(['operator_id'=>$this->user->id]);
            }
        }

        $this->dispatch('closeModal');
        $this->dispatch('operatorTable');
    }

    public function render()
    {
        return view('operator.create');
    }
}
