<?php

namespace Database\Factories;

use App\Models\Service\Score;
use App\Models\Service\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Score::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'score'         => $this->faker->randomNumber(1),
            'comments'      => collect(['Bien hecho', 'Excelente', 'Muy bien', 'Me encantó'])->random(),
            'type_user'     =>collect(['root', 'admin', 'employee', 'client'])->random(),
            'id_user'       =>User::all()->random()->id,
            'id_calificado' => User::all()->random()->id,
            'id_service'    => Service::all()->random()->id,
        ];
    }
}
