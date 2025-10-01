<?php

namespace App\Livewire\Profile;


use App\Models\UserLocations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Responsive;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class AddressList extends PowerGridComponent
{
    use WireUiActions;

    public $user;
    public $listeners = ['AddressList' => '$refresh'];

    public function datasource(): ?Builder
    {
        return UserLocations::query()->where('user_id', $this->user->id);
    }

    public function setUp(): array
    {
        return [
            Responsive::make()
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('address')
            ->add('city')
            ->add('address_latitude')
            ->add('address_longitude');
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->title('Address')
                ->field('address')
                ->fixedOnResponsive(),
            Column::add()
                ->title('City')
                ->field('city'),
            Column::add()
                ->title('Latitude')
                ->field('address_latitude'),
            Column::add()
                ->title('Longitude')
                ->field('address_longitude'),
            Column::action('Action')
                ->fixedOnResponsive()
        ];
    }

    public function actions(UserLocations $row): array
    {
        return [
            Button::add('my-custom-button')
                ->render(function (UserLocations $location) {
                    return Blade::render('profile.address-drop-down',
                        [
                            'id' => $location->id
                        ]);
                })
        ];
    }

    public function confirmRemove($id)
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Do you really want to remove this address?',
            'acceptLabel' => 'Yes, remove it',
            'method' => 'removeComplete',
            'icon' => 'warning',
            'params' => ['id' => $id],
        ]);

    }

    public function removeComplete(UserLocations $address)
    {

        $address->delete();
        $this->notification()->success(
            $title = 'Update',
            $description = 'Address Removed'
        );
    }
}


