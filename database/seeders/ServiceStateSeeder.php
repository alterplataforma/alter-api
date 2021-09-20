<?php

namespace Database\Seeders;

use App\Models\Service\ServiceState;
use Illuminate\Database\Seeder;

class ServiceStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < count(ServiceState::SERVICE); $i++) {
            ServiceState::create([
                'state' => ServiceState::SERVICE[$i],
                'colour' => ServiceState::SERVICE_COLOUR[$i],
            ]);
        }
    }
}
