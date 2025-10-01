<?php

namespace App\Livewire;

use Spatie\Permission\Models\Role;
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

final class PermissionTable extends PowerGridComponent
{
    use WithExport;

    public string $tableName = 'PermissionTable';

    public string $sortField = 'name';

    public string $sortDirection = 'asc';

    public int $perPage = 50;

    public array $perPageValues = [0, 5, 10, 20, 50, 100, 150];

    public bool $deferLoading = true;

    public string $loadingComponent = 'components.my-custom-loading';

    public $listeners = ['permissionTable' => '$refresh'];

    public function setUp(): array
    {
        $this->persist(['columns', 'filters', 'search']);

        return [
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
        $query = Role::query();
        return $query->select([
            '*'
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
            ->add('name')

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

            Column::action('Action')->visibleInExport(false)->fixedOnResponsive()
        ];
    }

    public function actions(Role $row): array
    {
        return [
            Button::add('my-custom-button')
                ->render(function (Role $user) {
                    return Blade::render('admin.users.components.permission-drop-down',
                        [
                            'id' => $user->id
                        ]);
                })
        ];
    }
}
