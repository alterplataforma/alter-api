<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'id' => '1081826503',
            'name' => 'Hanssel',
            'last_name' => 'Hurtado',
            'sex' => 'M',
            'email' => 'hansselhurtado@gmail.com',
            'password' => bcrypt('alter/*987?*'),
        ]);

    }
}
