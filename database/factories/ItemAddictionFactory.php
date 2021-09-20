<?php

namespace Database\Factories;

use App\Models\Service\ItemAddiction;
use App\Models\Service\ItemExtra;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemAddictionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ItemAddiction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'             => collect(['Papas Medianas','Coca Cola Original 400 ml Pet','Coca Cola Zero 500 ml Pet','Gaseosa Sprite Bot 400 ml','Mini Malteada Vainilla','Mini Malteada Macadamia','Mini Malteada Chocolate'])->random(),
            'type'              => collect(['0','1'])->random(),
            'aproved'           => collect(['0','1'])->random(),
            'price'             => $this->faker->randomNumber(4),
            'id_item_extra'     => ItemExtra::all()->random()->id,
            'id_user'           => User::all()->random()->id,
        ];
    }
}
