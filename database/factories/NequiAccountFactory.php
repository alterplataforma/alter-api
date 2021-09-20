<?php

namespace Database\Factories;

use App\Models\NequiAccount;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NequiAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NequiAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::all()->random();
        return [
            'id_user'                   => $user->id,
            'name'                      => $user->name.' '.$user->last_name,
            'document_number'           => $user->document_number,
            'phone'                     => $this->faker->unique()->e164PhoneNumber(),
            'status'                    => collect([0,1,2])->random(),
            'automatic_debit_token'     => $this->faker->uuid(),
        ];
    }
}
