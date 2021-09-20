<?php

namespace Database\Factories;

use App\Models\Location\City;
use App\Models\Service\Rate;
use App\Models\Service\RateType;
use App\Models\Service\ServiceType;
use App\Models\Service\Vehicle_type;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'group_city'            => collect([1,2,3])->random(),
            'type_city'             => collect([1,2,3])->random(),
            'value'                 => $this->faker->randomNumber(4),
            'comments'              => collect(['Mensajeria automovil por km TODAS LA CIUDADES', 'Taxi Taxi ciudad de Bogota', 'Tarifa minima para Mensajeria de Carro', 'Tarifa minima para Mensajeria en Camioneta','Taxi Taxi Ciudad de Bello','carro mensajeria TODAS LAS CIUDADES','Compras Automovil Medellin'])->random(),
            'id_service_type'       => ServiceType::all()->random()->id,
            'id_vehicle_type'       => Vehicle_type::all()->random()->id,
            'id_user'               => User::all()->random()->id,
            'id_rate_type'          => RateType::all()->random()->id,
            'title'                 => collect(['Mensajeria Carro','Mensajeria Moto','Mensajeria Camioneta','Mensajeria Taxi','Taxi Resto de Ciudades','Compras Bicicleta Medellin'])->random(),
            'id_city'               => City::all()->random()->id,
        ];
    }
}
