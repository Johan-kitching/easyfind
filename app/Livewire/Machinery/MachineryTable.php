<?php

namespace App\Livewire\Machinery;

use App\Models\Machinery;
use App\Models\MachineryType;
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

final class MachineryTable extends PowerGridComponent
{
    use WithExport, WireUiActions;

    public string $tableName = 'MachineryTable';

    public string $sortField = 'machineries.created_at';

    public string $sortDirection = 'desc';

    public int $perPage = 50;

    public array $perPageValues = [0, 5, 10, 20, 50, 100, 150];

    public bool $deferLoading = true;

    public string $loadingComponent = 'components.my-custom-loading';

    public $listeners = ['machineryTable' => '$refresh'];

    public $url;

    public function boot(): void
    {
        config(['livewire-powergrid.filter' => 'outside']);
    }

    public function setUp(): array
    {
        $this->persist(['columns', 'filters', 'search']);

        return [
            Exportable::make('Machinery - ' . Carbon::now()->format('d-m-Y_H-i-s'))
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
        $query = Machinery::query()
            ->leftjoin('machinery_types', 'machinery_type_id', 'machinery_types.id')
            ->leftjoin('users', 'machineries.operator_id', 'users.id')
            ->select('machineries.*', 'machinery_types.category', 'machinery_types.type', 'users.memberName');
        if (!Auth::user()->hasRole("Super Admin") || route('admin.machinery') != $this->url) {
            $query = $query->where('machineries.user_id', Auth::id());
//            dd("pass");
        }
        return $query;
    }

    public function relationSearch(): array
    {
        return [
            'machineries' => [
                'machinery_types' => ['category', 'type'],
                'users' => ['memberName']
            ]
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('category')
            ->add('type')
            ->add('memberName')
            ->add('views', fn(Machinery $model) => $model->views->count())
            ->add('created_at_formatted', fn(Machinery $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->add('Action');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
                ->sortable()
                ->searchable(),

            Column::make('Category', 'category')
                ->fixedOnResponsive()
                ->sortable()
                ->searchable(),

            Column::make('Type', 'type')
                ->sortable()
                ->searchable(),

            Column::make('Operator', 'memberName')
                ->sortable()
                ->searchable(),

            Column::make('Views', 'views'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Action')->visibleInExport(false)->fixedOnResponsive()
        ];
    }

    public function actions(Machinery $row): array
    {
        return [
            Button::add('my-custom-button')
                ->render(function (Machinery $machinery) {
                    return Blade::render('machinery.components.drop-down',
                        [
                            'id' => $machinery->id,
                            'model' => $machinery
                        ]);
                })
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('category', 'category')
                ->dataSource(MachineryType::select('category')
                    ->groupBy('category')
                    ->get()->toArray())
                ->optionValue('category')
                ->optionLabel('category'),
            Filter::select('type', 'type')
                ->dataSource(MachineryType::select('type')
                    ->groupBy('type')
                    ->get()->toArray())
                ->optionValue('type')
                ->optionLabel('type'),
        ];
    }

    public function confirmRemove($id)
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Do you really want to remove this machinery?',
            'acceptLabel' => 'Yes, remove it',
            'method' => 'removeComplete',
            'icon' => 'warning',
            'params' => ['id' => $id],
        ]);
    }

    public function removeComplete(Machinery $machinery)
    {
        $machinery->delete();
        $this->notification()->success(
            $title = 'Update',
            $description = 'User Removed'
        );
    }
}
