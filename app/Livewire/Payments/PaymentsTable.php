<?php

namespace App\Livewire\Payments;

use App\Models\Mechanic;
use App\Models\UserPayment;
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

final class PaymentsTable extends PowerGridComponent
{
    use WithExport, WireUiActions;

    public string $tableName = 'MechanicTable';

    public string $sortField = 'user_payments.created_at';

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
//            Responsive::make()
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
        return UserPayment::query()
            ->leftjoin('users', 'user_id', 'users.id')
            ->leftjoin('packages', 'user_payments.package_id', 'packages.id')
            ->select(
                'user_payments.*',
                'users.name as user_name',
                'packages.name as package_name'
            );
    }

    public function relationSearch(): array
    {
        return [
            'user_payments' => [
                'users' => ['name'],
                'packages' => ['name'],
            ]
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('users.name')
            ->add('Package')
            ->add('Amount')
            ->add('created_at_formatted', fn(UserPayment $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('id', 'id'),
            Column::make('User Name', 'user_name')
                ->sortable()
                ->searchable(),
            Column::make('Package', 'package_name')
                ->sortable()
                ->searchable(),
            Column::make('Amount', 'amount'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable()
        ];
    }

//    public function actions(UserPayment $row): array
//    {
//        return [
//            Button::add('my-custom-button')
//                ->render(function (UserPayment $mechanic) {
//                    return Blade::render('mechanic.components.drop-down',
//                        [
//                            'id' => $mechanic->id,
//                            'model' => $mechanic
//                        ]);
//                })
//        ];
//    }

    public function filters(): array
    {
        return [];
    }
}
