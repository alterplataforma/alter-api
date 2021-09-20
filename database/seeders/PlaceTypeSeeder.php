<?php

namespace Database\Seeders;

use App\Models\Service\PlaceType;
use Illuminate\Database\Seeder;

class PlaceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < count(PlaceType::CATEGORY); $i++) {
            PlaceType::create([
                'category' => PlaceType::CATEGORY[$i],
            ]);
        }
    }
}
