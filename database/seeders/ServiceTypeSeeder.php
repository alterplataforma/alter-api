<?php

namespace Database\Seeders;

use App\Models\Service\ServiceType;
use App\Models\User;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $user = $users->random();

        for ($i=0; $i < count(ServiceType::SERVICE); $i++) {
            ServiceType::create([
                'service_type' => ServiceType::SERVICE[$i],
                'id_user' => $user->id,
            ]);
        }

    }
}
