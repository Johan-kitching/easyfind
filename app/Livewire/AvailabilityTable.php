<?php

namespace App\Livewire;

use App\Models\Availability;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use WireUi\Traits\WireUiActions;

final class AvailabilityTable extends PowerGridComponent
{
    use WireUiActions;
    public string $title = 'Availability';
    public string $subjectId;
    public string $subject;
    public $listeners = ['AvailabilityTable'];
    public function setUp(): array
    {

        return [
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Availability::query()->where('parental_id', $this->subjectId)->where('parental_type', $this->subject);
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('start_date')
            ->add('end_date')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Start date', 'start_date')
                ->sortable()
                ->searchable(),

            Column::make('End date', 'end_date')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

    #[\Livewire\Attributes\On('remove')]
    public function confirmRemove($id): void
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Do you really want to remove this entry?',
            'acceptLabel' => 'Yes, remove it',
            'method' => 'removeEntry',
            'icon' => 'warning',
            'params' => ['id' => $id],
        ]);
    }

    public function removeEntry($info): void
    {
        $entry = Availability::find($info['id']);
        if ($entry->exists()) {
            $entry->delete();
        }
        $this->notification()->success(
            $title = 'Availability',
            $description = 'Entry Removed.'
        );
    }

    public function actions(Availability $row): array
    {
        return [
            Button::add('edit')
                ->slot('Remove')
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('remove', [$row->id])
        ];
    }
}
