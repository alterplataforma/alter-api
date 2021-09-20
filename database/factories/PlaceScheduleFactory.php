<?php

namespace Database\Factories;

use App\Models\Service\Place;
use App\Models\Service\PlaceSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaceScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PlaceSchedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type_schedule'             =>  collect([1,2,3])->random(),
            'since'                     =>  $this->faker->time($format = 'H:i:s', $max = 'now'),
            'since_type'                =>  collect(['AM','PM'])->random(),
            'until'                     =>  $this->faker->time($format = 'H:i:s', $max = 'now'),
            'until_type'                =>  collect(['AM','PM'])->random(),
        ];
    }
}
