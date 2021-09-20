<?php

namespace Database\Factories;

use App\Models\Location\Departament;
use App\Models\Location\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartamentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Departament::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_country' => Country::all()->random()->id,
            'department' => $this->faker->state(32),
        ];
    }
}
