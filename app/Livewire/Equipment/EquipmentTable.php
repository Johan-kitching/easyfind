<?php

namespace App\Livewire\Equipment;

use App\Models\Equipment;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Responsive;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use WireUi\Traits\WireUiActions;

final class EquipmentTable extends PowerGridComponent
{
    use WithExport, WireUiActions;

    public string $tableName = 'EquipmentTable';

    public string $sortField = 'equipment.created_at';

    public string $sortDirection = 'desc';

    public int $perPage = 50;

    public array $perPageValues = [0, 5, 10, 20, 50, 100, 150];

    public bool $deferLoading = true;

    public string $loadingComponent = 'components.my-custom-loading';

    public $listeners = ['equipmentTable' => '$refresh'];

    public function setUp(): array
    {
        $this->persist(['columns', 'filters', 'search']);

        return [
            Exportable::make('Equipment - ' . Carbon::now()->format('d-m-Y_H-i-s'))
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput()->showToggleColumns(),
            Footer::make()
                ->showPerPage($this->perPage, $this->perPageValues)
                ->showRecordCount(),
            Responsive::make()
        ];
    }

    protected function queryString(): array
    {
        return [
            'search' => ['except' => ''],
            'page' => ['except' => 1],
            ...$this->powerGridQueryString(),
        ];
    }

    public function datasource(): Builder
    {
        $query = Equipment::query()
            ->leftjoin('equipment_types', 'equipment.equipment_type_id', 'equipment_types.id')
            ->leftjoin('users', 'equipment.operator_id', 'users.id');
        return $query->select('equipment.*', 'equipment_types.category', 'equipment_types.type', 'equipment_types.model', 'users.memberName');
    }

    public function relationSearch(): array
    {
        return [
            'equipment' => [
                'equipment_types' => ['category', 'type','model'],
                'users' => ['name']
            ]
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('make')
            ->add('variant')
            ->add('name')
            ->add('created_at_formatted', fn(Equipment $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->add('Action');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
                ->sortable()
                ->searchable(),

            Column::make('Make', 'make')
                ->sortable()
                ->searchable(),

            Column::make('Model', 'variant')
                ->sortable()
                ->searchable(),

            Column::make('Operator', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Action')->visibleInExport(false)->fixedOnResponsive()
        ];
    }

    public function actions(Equipment $row): array
    {
        return [
            Button::add('my-custom-button')
                ->render(function (Equipment $equipment) {
                    return Blade::render('equipment.components.drop-down',
                        [
                            'id' => $equipment->id,
                            'model' => $equipment
                        ]);
                })
        ];
    }

    public function confirmRemove($id)
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Do you really want to remove this equipment?',
            'acceptLabel' => 'Yes, remove it',
            'method' => 'removeComplete',
            'icon' => 'warning',
            'params' => ['id' => $id],
        ]);
    }

    public function removeComplete(Equipment $equipment)
    {
        $equipment->delete();
        $this->notification()->success(
            $title = 'Update',
            $description = 'User Removed'
        );
    }
}
