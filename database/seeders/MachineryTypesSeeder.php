<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MachineryTypesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => 1, 'category' => 'Attachments', 'type' => 'Any', 'model' => 'Any', 'deleted_at' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'category' => 'Buses', 'type' => 'Any', 'model' => 'Any', 'deleted_at' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'category' => 'Cranes', 'type' => 'Any', 'model' => 'Any', 'deleted_at' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'category' => 'Dozers', 'type' => 'Any', 'model' => 'Any', 'deleted_at' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'category' => 'Excavators', 'type' => 'Any', 'model' => 'Any', 'deleted_at' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'category' => 'Forklifts', 'type' => 'Any', 'model' => 'Any', 'deleted_at' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'category' => 'Graders', 'type' => 'Any', 'model' => 'Any', 'deleted_at' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 8, 'category' => 'Loaders', 'type' => 'Any', 'model' => 'Any', 'deleted_at' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 9, 'category' => 'Rollers', 'type' => 'Any', 'model' => 'Any', 'deleted_at' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 10, 'category' => 'Tractors', 'type' => 'Any', 'model' => 'Any', 'deleted_at' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 11, 'category' => 'Trailers', 'type' => 'Any', 'model' => 'Any', 'deleted_at' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 12, 'category' => 'Trucks', 'type' => 'Any', 'model' => 'Any', 'deleted_at' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        foreach ($data as $item) {
            DB::table('machinery_types')->updateOrInsert(
                ['id' => $item['id']],
                $item
            );
        }
    }
}
