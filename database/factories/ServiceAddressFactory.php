<?php

namespace Database\Factories;

use App\Models\Location\City;
use App\Models\Service\Service;
use App\Models\Service\ServiceAddresOrder;
use App\Models\Service\ServiceAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ServiceAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_service'                =>  Service::all()->random()->id,
            'id_city'                   =>  City::all()->random()->id,
            'address'                   =>  $this->faker->address(8),
            'latitude'                  =>  $this->faker->latitude(8),
            'longitude'                 =>  $this->faker->longitude(8),
            'id_service_addres_order'   =>  ServiceAddresOrder::all()->random()->id,
        ];
    }
}
