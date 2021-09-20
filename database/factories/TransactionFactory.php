<?php

namespace Database\Factories;

use App\Models\Service\Service;
use App\Models\Service\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_service'                            =>  Service::all()->random()->id,
            'commission_alter'                      =>  $this->faker->randomFloat($nbMaxDecimals = 2, $min = 100, $max = 1000),
            'iva_commission_alter'                  =>  $this->faker->randomFloat($nbMaxDecimals = 2, $min = 50, $max = 100),
            'commission_first_level_client'         =>  $this->faker->randomFloat($nbMaxDecimals = 2, $min = 50, $max = 100),
            'id_first_level_client'                 =>  User::all()->random()->id,
            'commission_second_level_client'        =>  $this->faker->randomFloat($nbMaxDecimals = 2, $min = 100, $max = 1000),
            'id_second_level_client'                =>  User::all()->random()->id,
            'commission_third_level_client'         =>  $this->faker->randomFloat($nbMaxDecimals = 2, $min = 50, $max = 100),
            'id_third_level_client'                 =>  User::all()->random()->id,
            'total_client'                          =>  $this->faker->randomFloat($nbMaxDecimals = 2, $min = 100, $max = 1000),
            'commission_alter_provider'             =>  $this->faker->randomFloat($nbMaxDecimals = 2, $min = 50, $max = 200),
            'iva_commission_alter_provider'         =>  $this->faker->randomFloat($nbMaxDecimals = 2, $min = 50, $max = 200),
            'commission_first_level_provider'       =>  $this->faker->randomFloat($nbMaxDecimals = 2, $min = 50, $max = 200),
            'id_first_level_provider'               =>  User::all()->random()->id,
            'commission_second_level_provider'      =>  $this->faker->randomFloat($nbMaxDecimals = 2, $min = 50, $max = 200),
            'id_second_level_provider'              =>  User::all()->random()->id,
            'commission_third_level_provider'       =>  $this->faker->randomFloat($nbMaxDecimals = 2, $min = 50, $max = 200),
            'id_third_level_provider'               =>  User::all()->random()->id,
            'total_provider'                        =>  $this->faker->randomFloat($nbMaxDecimals = 2, $min = 100, $max = 1000),
            'value_nequi'                           =>  $this->faker->randomFloat($nbMaxDecimals = 2, $min = 50, $max = 200),
            'commission_nequi'                      =>  $this->faker->randomFloat($nbMaxDecimals = 2, $min = 50, $max = 200),
        ];
    }
}
