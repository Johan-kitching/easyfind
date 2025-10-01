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

#[AllowDynamicProperties] class Edit extends ModalComponent
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user->id],
            'password' => ['nullable'] + $this->passwordRules(),
            'password_confirmation' => ['same:password'],
        ];
    }

    public function mount(User $user)
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
        $this->user = $user;
        $this->name = $user->name;
        $this->number = $user->number;
        $this->email = $user->email;
        $this->equipment = $user->machinery->pluck('id')->toArray();

    }

    public function updated($fields): void
    {
        $this->validateOnly($fields);
    }

    public function save(){
        $this->validate();
        $this->user->update([
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
        ]);
//        dd(count($this->equipment));
        if(count($this->equipment) > 0){
            foreach ($this->equipments->where('operator_id',$this->user->id) as $equipment){
                Machinery::where('id', $equipment)->update(['operator_id'=>null]);
            }
            foreach ($this->equipment as $equipment){
                Machinery::where('id', $equipment)->update(['operator_id'=>$this->user->id]);
            }
        }

        if(!empty($this->transporter)){
            foreach ($this->transporters->where('operator_id',$this->user->id) as $transporter){
                Transporter::where('id', $transporter)->update(['operator_id'=>null]);
            }
            foreach ($this->transporter as $transporter){
                Transporter::find($transporter)->update(['operator_id'=>$this->user->id]);
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
