<?php

namespace Database\Factories;

use App\Models\Service\ItemExtra;
use App\Models\Service\PlaceItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemExtraFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ItemExtra::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'          => collect(['Elige Acompañamiento','Elige Bebida','Elige Sabor de la Malteada','Elige Papas Medianas','Elige Bebida','Elige Opción','Adiciones'])->random(),
            'aproved'       => collect(['0','1'])->random(),
            'id_place_item' => PlaceItem::all()->random()->id,
            'id_user'       => User::all()->random()->id,
        ];
    }
}
