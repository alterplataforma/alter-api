<?php

namespace Database\Seeders;

use App\Models\Service\Vehicle_type;
use App\Models\User;
use Illuminate\Database\Seeder;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::all()->random();

        for ($i=0; $i < count(Vehicle_type::TYPE); $i++) {
            Vehicle_type::create([
                'vehicle_type' => Vehicle_type::TYPE[$i],
                'id_user' => $user->id,
            ]);
        }
    }
}
