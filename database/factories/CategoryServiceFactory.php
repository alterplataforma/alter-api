<?php

namespace Database\Factories;

use App\Models\Service\Category;
use App\Models\Service\CategoryService;
use App\Models\Service\Place;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategoryService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'                  =>  $this->faker->unique()->jobTitle(),
            'id_category'           =>  Category::all()->random()->id,
            'id_place'              =>  Place::all()->random()->id,
            'id_user'               =>  User::all()->random()->id,
        ];
    }
}
