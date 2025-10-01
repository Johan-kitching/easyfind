<?php

namespace App\Livewire;

use Livewire\Component;

class NavigationMenusDropdown extends Component
{
    public $menus = [];
    public $menuLocation;

    public function mount($menuLocation): void
    {
        $this->menus = [
            'hiw' => ['route' => 'how.it.works', 'name' => 'How it works', 'permission'=>'All'],
//            'Home' => ['route' => 'dashboard', 'name' => 'Search', 'permission'=>'All'],
            'Find Machinery' => ['route' => 'search.machinery', 'name' => 'Find Machinery', 'permission'=>'All'],
            'Find Mechanic' => ['route' => 'search.mechanic', 'name' => 'Find Mechanic', 'permission'=>'All'],
            'Find Transporter' => ['route' => 'search.transporter', 'name' => 'Find Transporter', 'permission'=>'All'],
//            'Search' => ['route' => 'Search', 'name' => 'Search', 'permission'=>'All'],

            'Register' => ['route' => 'register', 'name' => 'Register', 'permission'=>'Guest'],
            'Login' => ['route' => 'login', 'name' => 'Login', 'permission'=>'Guest'],
//            'Dashboard' => ['route' => 'dashboard', 'name' => 'Dashboard', 'permission'=>'Dashboard'],
            'Manage' => [
                'route' => '#',
                'name' => 'Manage',
                'permission'=>'Company',
                'SubMenu'=>[
                    'My Machinery' => ['route' => 'machinery', 'name' => 'My Machinery', 'permission'=>'My Machinery'],
                    'My Mechanic' => ['route' => 'mechanic', 'name' => 'My Mechanic', 'permission'=>'My Mechanic'],
//            'My Equipment' => ['route' => 'equipment', 'name' => 'My Equipment', 'permission'=>'My Equipment'],
                    'My Transporter ' => ['route' => 'transporter', 'name' => 'My Transporter', 'permission'=>'My Transporter'],
//            'My Rentals' => ['route' => 'rentals', 'name' => 'My Rentals', 'permission'=>'My Rentals'],
                    'My Operators' => ['route' => 'operators', 'name' => 'My Operators', 'permission'=>'My Operators'],
                ],
            ],
            'Admin' => [
                'route'=>'#',
                'name' => 'Admin',
                'permission'=>'Admin',
                'SubMenu'=>[
                    'Users'=>['route'=>'admin-users', 'name' => 'Users', 'permission'=>'Admin Users'],
                    'Permissions'=>['route'=>'admin-permissions', 'name' => 'Permissions', 'permission'=>'Admin Permissions'],
                    'Payments'=>['route'=>'admin-payments', 'name' => 'Payments', 'permission'=>'Admin Payment'],
                    'Machinery'=>['route'=>'admin.machinery', 'name' => 'Machinery', 'permission'=>'Admin Machinery'],
                    'Machinery Categories'=>['route'=>'admin.machinery.types', 'name' => 'Machinery Type', 'permission'=>'Admin Machinery Type'],
//                    'Equipment'=>['route'=>'admin.equipment', 'name' => 'Equipment', 'permission'=>'Admin Equipment'],
//                    'Equipment Categories'=>['route'=>'admin.equipment.types', 'name' => 'Equipment Categories', 'permission'=>'Admin Equipment Type'],
                    'Mechanic' => ['route' => 'admin.mechanic', 'name' => 'Mechanic', 'permission'=>'Admin Mechanic'],
//                    'Rentals'=>['route'=>'admin-rentals', 'name' => 'Rentals', 'permission'=>'Admin Rentals'],
                    'Transporter Categories'=>['route'=>'admin.transporter.types', 'name' => 'Transporter Type', 'permission'=>'Admin Transporter Type'],
                    'Transporter' => ['route' => 'admin.transporter', 'name' => 'Transporter', 'permission'=>'Admin Transporter'],
                    'Packages' => ['route' => 'admin.packages', 'name' => 'Packages', 'permission'=>'Admin Packages'],
                ]
            ],
        ];
    }

    public function render()
    {
        return view('navigation-menus-dropdown');
    }
}
