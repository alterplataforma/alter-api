<?php

namespace Database\Seeders;

use App\Models\Service\ServiceAddresOrder;
use Illuminate\Database\Seeder;

class ServiceAddresOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < count(ServiceAddresOrder::ORDER); $i++) {
            ServiceAddresOrder::create([
                'order' => ServiceAddresOrder::ORDER[$i],
            ]);
        }
    }
}
