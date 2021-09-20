<?php

namespace Database\Factories;

use App\Models\Service\Vehicle;
use App\Models\Service\Vehicle_type;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehiclefactoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        return [
            'vehicle' => $this->faker->name(10),
            'id_user' => User::all()->random()->id,
            'id_vehicle_type' => Vehicle_type::all()->random()->id,
            'plate' => $this->faker->randomNumber(6),
            'model' => $this->faker->name(6),
            'brand' => $this->faker->name(10),
            'engine_number' => $this->faker->randomNumber(8),
            'chasis_number' => $this->faker->randomNumber(8),
            'expiration_date_soat' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'expiration_date_tecnico' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'proprietor_document_number' => $this->faker->randomNumber(8),
            'proprietor_name' => $this->faker->name(10),
        ];
    }
}
