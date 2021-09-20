<?php

namespace Database\Seeders;

use App\Models\Location\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < count(Country::COUNTRY); $i++) {
            Country::create([
                'country' => Country::COUNTRY[$i],
            ]);
        }
    }
}
