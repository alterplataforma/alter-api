<?php

namespace Database\Factories;

use App\Models\Service\ItemAddiction;
use App\Models\Service\ItemDomicile;
use App\Models\Service\PlaceItem;
use App\Models\Service\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemDomicileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ItemDomicile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'instructions'              => collect(['Apartamento 5, piso 3',null,'Casa blanca de rejas','Edificio Norte'])->random(),
            'extra'                     => collect(['0','1'])->random(),
            'amount'                    => $this->faker->numberBetween($min = 1, $max = 20),
            'id_place_item'             => PlaceItem::all()->random()->id,
            'id_service'                => Service::all()->random()->id,
            'id_item_addiction'         => ItemAddiction::all()->random()->id,
        ];
    }
}
