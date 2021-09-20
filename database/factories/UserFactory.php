<?php

namespace Database\Factories;

use App\Models\Location\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $document = '1'.$this->faker->randomNumber(5).$this->faker->randomNumber(4);
        return [
            'id'                => $document,
            'id_city'           => City::all()->random()->id,
            'email'             => $this->faker->unique()->safeEmail(),
            'document_number'   => $document,
            'password'          => bcrypt('alter'),
            'name'              => $this->faker->name(10),
            'last_name'         => $this->faker->lastName(10),
            'sex'               => collect([$this->model::MAS, $this->model::FEM])->random(),
            'birth_date'        => $this->faker->date(),
            'cell_phone'        => $this->faker->phoneNumber(8),
            'address'           => $this->faker->address(8),
            'image_user'        => $this->faker->imageUrl($width = 640, $height = 480),
            'alter_cash'        => $this->faker->randomNumber(5),
            'tokenfcm'          => $this->faker->uuid(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
