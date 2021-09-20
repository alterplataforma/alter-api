<?php

namespace Database\Seeders;

use App\Models\FavoriteAddress;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FavoriteAddress::factory(8)->create();
    }
}
