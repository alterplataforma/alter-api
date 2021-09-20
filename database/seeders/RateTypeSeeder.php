<?php

namespace Database\Seeders;

use App\Models\Service\RateType;
use Illuminate\Database\Seeder;

class RateTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < count(RateType::TYPE); $i++) {
            RateType::create([
                'rate' => RateType::TYPE[$i],
            ]);
        }
    }
}
