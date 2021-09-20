<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Support\SupportAnswer;
use App\Models\Support\SupportTicket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupportAnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SupportAnswer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'answer' => collect(['No tenes nada','Este es un error de la plataforma Nequi de Bancolombia, ya estÃ¡n trabajando para arreglarlo.','Hola  ALTER te desea exitos para este nuevo año, mantente activado y te monitorearemos para ver que pasa','Bienvenido a Alter','Hola, puedes comunicarte con nosotros, si es menos de 50.000 te podemos hacer la transferencia directa para que que la transferencia no te cueste nada. whatsapp 319 2709540'])->random(),
            'id_operator' => User::all()->random()->id,
            'id_support_ticket' => SupportTicket::all()->random()->id,
        ];
    }
}
