<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\User;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < count(Banner::IMAGE) ; $i++) {
            Banner::create([
                'image'     => Banner::IMAGE[$i].'.png',
                'id_user'   => User::all()->random()->id,
            ]);
        }

    }
}
