<?php

namespace Database\Factories;

use App\Models\Location\City;
use App\Models\Recommendation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecomendationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recommendation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_recomendado' => User::all()->random()->id,
            'id_user' => User::all()->unique()->random()->id
        ];
    }
}
