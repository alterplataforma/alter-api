<?php

namespace Database\Factories;

use App\Models\Service\Payment_type;
use App\Models\Service\Service;
use App\Models\Service\ServiceState;
use App\Models\Service\ServiceType;
use App\Models\Service\Vehicle;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServicesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $value = $this->faker->randomNumber(8);
        return [
            'id_service_type' => ServiceType::all()->random()->id,
            'id_vehicle' => Vehicle::all()->random()->id,
            'id_payment_type' => Payment_type::all()->random()->id,
            'id_client' => User::all()->random()->id,
            'state_id' => ServiceState::all()->random()->id,
            'id_provider' => User::all()->random()->id,
            'arrival_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'finish_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'estimated_time' => $this->faker->randomNumber(4),
            'Time_for_repair' => $this->faker->randomNumber(1),
            'value' => $value,
            'total' => $value,

        ];
    }
}
