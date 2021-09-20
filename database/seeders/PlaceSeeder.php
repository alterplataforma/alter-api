<?php

namespace Database\Seeders;

use App\Models\Service\Place;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < count(Place::PLACE_NAME); $i++) {
            Place::factory()->create([
                'name'          => Place::PLACE_NAME[$i],
                'image'         => Place::IMAGE[$i],
                'description'   => Place::PLACE_NAME[$i],
            ]);
        }

    }
}
