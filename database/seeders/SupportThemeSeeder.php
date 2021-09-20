<?php

namespace Database\Seeders;

use App\Models\Support\SupportTheme;
use App\Models\User;
use Illuminate\Database\Seeder;

class SupportThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < count(SupportTheme::THEME); $i++) {
            SupportTheme::create([
                'theme' => SupportTheme::THEME[$i],
                'id_user_register' => User::all()->random()->id,
            ]);
        }
    }
}
