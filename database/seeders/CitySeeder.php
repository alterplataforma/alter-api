<?php

namespace Database\Seeders;

use App\Models\Location\City;
use App\Models\Location\Departament;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create([
            'city'          =>  'Todas las ciudades',
            'id_department' =>  Departament::all()->random()->id
        ]);
    }
}
