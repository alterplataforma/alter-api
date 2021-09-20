<?php

namespace Database\Factories;

use App\Models\Cash\CashRetirement;
use App\Models\Cash\CashState;
use App\Models\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CashRetirementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CashRetirement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value' => $this->faker->randomNumber(5),
            'id_state' => CashState::all()->random()->id,
            'ip' => $this->faker->ipv4(),
            'id_user' => User::all()->random()->id
        ];
    }
}
