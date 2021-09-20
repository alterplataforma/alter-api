<?php

namespace Database\Factories;

use App\Models\Cash\CashShipping;
use App\Models\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CashShippingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CashShipping::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value'             => $this->faker->randomNumber(4),
            'ip'                => $this->faker->ipv4(),
            'id_user_receive'   => User::all()->random()->id,
            'id_user_shipping'  => User::all()->random()->id
        ];
    }
}
