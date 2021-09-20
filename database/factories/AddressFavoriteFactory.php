<?php

namespace Database\Factories;

use App\Models\FavoriteAddress;
use App\Models\Location\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFavoriteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FavoriteAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_user' =>  User::all()->random()->id,
            'id_city' => City::all()->random()->id,
            'title' => $this->faker->title(10),
            'address' => $this->faker->address(10),
            'indications' => $this->faker->text(20),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
        ];
    }
}
