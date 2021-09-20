<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Support\SupportTheme;
use App\Models\Support\SupportTicket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupportTicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SupportTicket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => collect(['Cómo veo mi saldo','Buenas noches, porque no da la fusion entre la cuenta alter con mi cuenta nequi','Buenas noches es que no me aparece el servicio en la pantalla. Notifica pero no me aparece','Que otro medio puedo utilizar para cobrar el servicio prestado','Hola buenos dias Tengo una duda o mas bien un inconveniente Pasa que me conecto  pero no recibo envios he borrado cache y datos y sigue igual','Buenos días señores ALTER quería preguntarles por qué motivo la aplicación nunca funciona si ya llevo con ella instalada como un año y solo me an dado un servicio y para buscar servicio tampoco encuentra uno espero respuesta a mi inquietud'])->random(),
            'id_user' => User::all()->random()->id,
            'ticket' => str_pad(mt_rand(1, 99), 1, '0', STR_PAD_LEFT) . date("i") . str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT) . date("hsd"),
            'id_support_theme' => SupportTheme::all()->random()->id,
        ];
    }
}
