<?php

namespace Database\Seeders;

use App\Models\Cash\CashState;
use Illuminate\Database\Seeder;

class CashStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < count(CashState::STATUS); $i++) {
            CashState::create([
                'state' => CashState::STATUS[$i],
            ]);
        }
    }
}
