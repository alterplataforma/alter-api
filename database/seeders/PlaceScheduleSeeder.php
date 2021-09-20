<?php

namespace Database\Seeders;

use App\Models\Service\PlaceSchedule;
use Illuminate\Database\Seeder;

class PlaceScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 5; $i++) {
            PlaceSchedule::factory()->create([
                'id_place'          => $i,
            ]);
        }
    }
}
