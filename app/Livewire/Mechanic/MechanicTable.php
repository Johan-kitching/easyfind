<?php

namespace App\Livewire\Mechanic;

use App\Models\Mechanic;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Responsive;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use WireUi\Traits\WireUiActions;

final class MechanicTable extends PowerGridComponent
{
    use WithExport, WireUiActions;

    public string $tableName = 'MechanicTable';

    public string $sortField = 'mechanics.created_at';

    public string $sortDirection = 'desc';

    public int $perPage = 50;

    public array $perPageValues = [0, 5, 10, 20, 50, 100, 150];

    public bool $deferLoading = true;

    public string $loadingComponent = 'components.my-custom-loading';

    public $listeners = ['mechanicTable' => '$refresh'];

    public $url;

    public function boot(): void
    {
        config(['livewire-powergrid.filter' => 'outside']);
    }

    public function setUp(): array
    {
        $this->persist(['columns', 'filters', 'search']);

        return [
            Exportable::make('Mechanic - ' . Carbon::now()->format('d-m-Y_H-i-s'))
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
        $query = Mechanic::query()
            ->leftjoin('users', 'user_id', 'users.id')
            ->leftjoin('mechanic_type', 'mechanic_type_id', 'mechanic_type.id')
            ->select('mechanics.*', 'users.name as memberName', 'mechanic_type.name as type');
        if (!Auth::user()->hasRole("Super Admin") || route('admin.mechanic') != $this->url) {
            $query = $query->where('mechanics.user_id', Auth::id());
//            dd("pass");
        }
        return $query;
    }

    public function relationSearch(): array
    {
        return [
            'mechanic' => [
                'users' => ['memberName']
            ]
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('type')
            ->add('memberName')
            ->add('views', fn(Mechanic $model) => $model->views->count())
            ->add('created_at_formatted', fn(Mechanic $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->add('Action');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
                ->sortable()
                ->searchable(),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Type', 'type'),
            Column::make('Views', 'views'),
            Column::make('Created By', 'memberName')
                ->sortable()
                ->searchable(),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Action')->visibleInExport(false)->fixedOnResponsive()
        ];
    }

    public function actions(Mechanic $row): array
    {
        return [
            Button::add('my-custom-button')
                ->render(function (Mechanic $mechanic) {
                    return Blade::render('mechanic.components.drop-down',
                        [
                            'id' => $mechanic->id,
                            'model' => $mechanic
                        ]);
                })
        ];
    }

    public function filters(): array
    {
        return [];
    }

    public function confirmRemove($id)
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Do you really want to remove this mechanic?',
            'acceptLabel' => 'Yes, remove it',
            'method' => 'removeComplete',
            'icon' => 'warning',
            'params' => ['id' => $id],
        ]);
    }

    public function removeComplete(Mechanic $mechanic)
    {
        $mechanic->delete();
        $this->notification()->success(
            $title = 'Update',
            $description = 'User Removed'
        );
    }
}
