<?php

namespace App\Livewire\Transporter;

use App\Models\Machinery;
use App\Models\MachineryType;
use App\Models\Transporter;
use App\Models\TransporterType;
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

final class TransporterTable extends PowerGridComponent
{
    use WithExport, WireUiActions;

    public string $tableName = 'transporterTable';

    public string $sortField = 'transporters.created_at';

    public string $sortDirection = 'desc';

    public int $perPage = 50;

    public array $perPageValues = [0, 5, 10, 20, 50, 100, 150];

    public bool $deferLoading = true;

    public string $loadingComponent = 'components.my-custom-loading';

    public $listeners = ['transporterTable' => '$refresh'];

    public $url;

    public function boot(): void
    {
        config(['livewire-powergrid.filter' => 'outside']);
    }

    public function setUp(): array
    {
        $this->persist(['columns', 'filters', 'search']);

        return [
            Exportable::make('Transporters - ' . Carbon::now()->format('d-m-Y_H-i-s'))
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
        $query = Transporter::query()
            ->leftjoin('transporter_types', 'transporter_type_id', 'transporter_types.id')
            ->leftjoin('users', 'transporters.operator_id', 'users.id')
            ->select('transporters.*', 'transporter_types.name');
        if (!Auth::user()->hasRole("Super Admin") || route('admin.machinery') != $this->url) {
            $query = $query->where('transporters.user_id', Auth::id());
//            dd("pass");
        }
        return $query;
    }

    public function relationSearch(): array
    {
        return [
            'transporters' => [
                'transporter_types' => ['name'],
                'users' => ['memberName']
            ]
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name', fn(Transporter $model) => $model->type->name)
            ->add('memberName')
            ->add('views', fn(Transporter $model) => $model->views->count())
            ->add('created_at_formatted', fn(Transporter $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->add('Action');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
                ->sortable()
                ->searchable(),

            Column::make('Type', 'name')
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

    public function actions(Transporter $row): array
    {
        return [
            Button::add('my-custom-button')
                ->render(function (Transporter $transporter) {
                    return Blade::render('transporter.components.drop-down',
                        [
                            'id' => $transporter->id,
                            'model' => $transporter
                        ]);
                })
        ];
    }

    public function filters(): array
    {
        return [

            Filter::select('name', 'transporter_types.id')
                ->dataSource(TransporterType::all()->toArray())
                ->optionValue('id')
                ->optionLabel('name'),
        ];
    }

    public function confirmRemove($id)
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Do you really want to remove this transporter?',
            'acceptLabel' => 'Yes, remove it',
            'method' => 'removeComplete',
            'icon' => 'warning',
            'params' => ['id' => $id],
        ]);
    }

    public function removeComplete(Transporter $transporter)
    {
        $transporter->delete();
        $this->notification()->success(
            $title = 'Update',
            $description = 'transporter Removed'
        );
    }
}
