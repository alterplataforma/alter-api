<?php

namespace Database\Seeders;

use App\Models\Service\Payment_type;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < count(Payment_type::TYPE); $i++) {
            Payment_type::create([
                'payment_type' => Payment_type::TYPE[$i],
            ]);
        }
    }
}
