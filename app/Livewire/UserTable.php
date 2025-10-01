<?php

namespace App\Livewire;

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

final class UserTable extends PowerGridComponent
{
    use WithExport, WireUiActions;

    public string $tableName = 'UserTable';

    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    public int $perPage = 50;

    public array $perPageValues = [0, 5, 10, 20, 50, 100, 150];

    public bool $deferLoading = true;

    public string $loadingComponent = 'components.my-custom-loading';

    public $listeners = ['userTable' => '$refresh'];

    public function setUp(): array
    {
        $this->persist(['columns', 'filters', 'search']);

        return [
            Exportable::make('Users-' . Carbon::now()->format('d-m-Y_H-i-s'))
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
        $query = User::query();
        return $query->select([
            'users.*'
        ]);
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('memberName')
            ->add('companyName')
            ->add('email')
            ->add('package', fn(User $model) => $model->package->name ?? 'N/A')
            ->add('status', function ($model) {
                return Blade::render('components.status',
                    [
                        'status' => $model->status,
                        'label' => $model->status,

                    ]);
            })
            ->add('created_at_formatted', fn(User $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->add('Action');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
                ->sortable()
                ->searchable(),

            Column::make('Name', 'memberName')
                ->sortable()
                ->searchable(),

            Column::make('Company', 'companyName')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),

            Column::make('Package', 'package'),

            Column::make('Type', 'type')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'status')
                ->sortable()->searchable()->fixedOnResponsive(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Action')->visibleInExport(false)->fixedOnResponsive()
        ];
    }

    public function actions(\App\Models\User $row): array
    {
        return [
            Button::add('my-custom-button')
                ->render(function (User $user) {
                    return Blade::render('admin.users.components.drop-down',
                        [
                            'id' => $user->id
                        ]);
                })
        ];
    }
    public function confirmRemove($id)
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Do you really want to remove this user?',
            'acceptLabel' => 'Yes, remove it',
            'method' => 'removeComplete',
            'icon' => 'warning',
            'params' => ['id' => $id],
        ]);

    }

    public function removeComplete(User $user)
    {

        $user->delete();
        $this->notification()->success(
            $title = 'Update',
            $description = 'User Removed'
        );
    }
}
