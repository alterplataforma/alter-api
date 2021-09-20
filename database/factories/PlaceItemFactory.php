<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Service\CategoryService;
use App\Models\Service\Place;
use App\Models\Service\PlaceItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaceItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PlaceItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'                 =>  $this->faker->unique()->jobTitle(),
            'image'                 =>  $this->faker->imageUrl($width = 640, $height = 480),
            'value'                 =>  $this->faker->randomNumber(4),
            'extras'                =>  collect([1,2])->random(),
            'approved'              =>  collect([1,2])->random(),
            'customizable'          =>  collect([1,2])->random(),
            'description'           =>  collect(['Super economico','Super delicioso','Para los mejores momentos'])->random(),
            'id_user'               =>  User::all()->random()->id,
            'id_place'              =>  Place::all()->random()->id,
            'id_category_service'   =>  CategoryService::all()->random()->id,
        ];
    }
}
