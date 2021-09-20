<?php

namespace Database\Factories;

use App\Models\Location\City;
use App\Models\Service\Place;
use App\Models\Service\PlaceType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Place::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_place_type'         => PlaceType::all()->random()->id,
            'id_city'               => City::all()->random()->id,
            'id_user'               => User::all()->random()->id,
            'approved'              => collect([1,0])->random(),
            'address'               => $this->faker->address(),
            'longitude'             => $this->faker->longitude(),
            'latitude'              => $this->faker->latitude(),
            'headquarter'           => collect([1,0])->random(),
            'register_type'         => collect([1,0])->random(),
            'product_charge'        => collect([1,0])->random(),
            'proprietor_name'       => User::all()->random()->name,
        ];
    }
}
