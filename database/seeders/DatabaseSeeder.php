<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeders=[PermissionsSeeder::class, UserSeeder::class, MachineryTypesSeeder::class];

        if (in_array(App::Environment(), ['staging', 'qa', 'production'])) {
            //** BEGIN: Add current SPRINT seeders here, to be deployed on PROD + STAGING
            $this->call([PermissionsSeeder::class, UserSeeder::class]);
//                         $this->call([RelationshipSeeder::class, PermissionSeeder::class, StatusSeeder::class, InputExceptionSeeder::class, AccountTypeSeeder::class, SectorSeeder::class, OccupationSeeder::class, EducationInstitutionSeeder::class, FieldOfStudySeeder::class]);
            // */
            $this->call([]);
            //** END */
        } else {
            $this->call($seeders);
        }
    }
}
