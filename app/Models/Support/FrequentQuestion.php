<?php

namespace App\Models\Support;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrequentQuestion extends Model
{
    use HasFactory;

    protected $table = 'frequent_questions';

    protected $fillable = [
        'question', 'answer','keywords',
        'id_user_register','id_support_theme',
    ];

    public function user() {
        return $this->belongsTo(User::class,'id_user_register');
    }

    public function supporTheme() {
        return $this->belongsTo(SupportTheme::class,'id_support_theme');
    }


    public static function findQuestion($key = null, $theme = null){
        $question = FrequentQuestion::where('status', 1);
        if ($key) {
            $question->where('question','like','%'.$key.'%')
                    ->orWhere('keywords','like','%'.$key.'%');
        }elseif($theme){
            $question->where('id_support_theme',$theme);
        }
        return $question->orderBy('question')->get();

    }

    const THEME_VALUE = [1,1,2,2,1,1,1,1,1,2,2,2,1,2,1,2,2,1,2,1,2];

    const QUESTIONS = [
        '¿Cómo funciona la aplicación?',
        '¿ En que dispositivos funciona la aplicación?',
        '¿ Cómo genero ingresos con Alter ?',
        '¿ Cuándo recibo mi bonificación por mi grupo de referidos ?',
        '¿ Qué pasa si mi servicio no llega ?',
        '¿Qué pasa si mi paquete llega averiado o no llega a su destino? ',
        '¿Cómo puedo retirar mi dinero de la aplicación ?',
        '¿En qué momento se realiza el pago del  servicio?',
        '¿Si cancelo el servicio esto me genera algún costo?',
        '¿Es obligatorio referir usuarios a alter?',
        '¿Puedo solicitar varios servicios al mismo tiempo?',
        '¿Están seguros mis datos personales en Alter?',
        '¿Cómo se define la tarifa de los servicios de Alter?',
        '¿Quién me garantiza la calidad de mi servicio o producto?',
        '¿Puedo solicitar el servicio en una dirección diferente a la que me encuentro? ',
        '¿Por qué medio me puedo comunicarme con el prestador del servicio directamente? ',
        '¿Dónde puedo notificar las novedades o calificar el servicio? ',
        '¿Cómo ingreso un referido ?',
        '¿Puedo eliminar mis referidos?',
        '¿Puedo cambiar mis referidos ?',
    ];

    const ANSWER = [
        'Alter es una aplicación que sirve para conectar personas que requieren servicios específicos con personas que prestan estos servicios.',
        'Podrás descargarla de forma gratuita a través de Play  Store  y  apple store o si tienes dificultad para encontrarla puedes ingresar a la pagina www.alterclub.com donde se encuentra el acceso directo para la descarga, debes de ingresar tus datos personales para el registro. También te recomendamos descargar la app Nequi y enlazarla con Alter para hacer pagos automáticos',
        'Dispositivos móviles con sistema operativo IOS, Android, plataforma web y API dispositivos móviles con sistema operativo Android 4.3m y IOS 9 en adelante, con conexión a internet y cámara frontal',
        '1. prestando servicios.
            2. a  través de las comisiones de los servicios que piden o prestan  mis referidos y el resto del grupo. ',
        'Las bonificaciones  se cargan automáticamente a tu cuenta de Alter cada que alguien del  grupo pida o presta un servicio.',
        'Si el proveedor no llega al sitio donde comienza su servicio, este no será cobrado.',
        'Los servicios que se prestan a través de la plataforma Alter son entre 2 personas particulares, por lo tanto quien presta el servicio debe responder por el cumplimiento e integridad, Si el prestador del servicio no responde, podrá realizar una queja o reclamo en la aplicación, donde dado el caso, se suministrará  la información completa del prestador de servicios y el afectado podrá iniciar un proceso formal.',
        'El dinero todo el tiempo estará visible en la aplicación y podrá ser retirado después de cada fecha de corte (ver en la app "estado de cuenta"). Lo que tenga en bonificación se encontrara en la sección de cuenta con la opción solicitar dinero, el cual tendrá un costo bancario que el usuario debe de asumir y  tarda 2 días hábiles para ser depositado en su cuenta nequi ',
        'El pago del servicio es realizado inmediatamente el usuario que presta el servicio, llegue al punto de encuentro.',
        ' Si ya ha transcurrido el tiempo estipulado mencionado en los términos y condiciones se debe cancelar una tarifa mínima ',
        'No, pero se recomienda para que tu grupo pueda seguir creciendo, ya que el objetivo de la plataforma es el trabajo colaborativo',
        'Si, puedes solicitar varios servicios ya que el objetivo de Alter es que hagas todo a través de la aplicación  y desde la comodidad de tu casa ',
        'Si, tus datos personales estarán protegidos bajo las condiciones estipuladas en los términos y condiciones y la ley de protección de datos.',
        'Las tarifas de taxis están estandarizadas según las normativas de ministerio de transporte de Colombia y las tarifas de mensajería se definen basadas en un estudio realizado en el mercado.',
        'Alter establece reglas a las personas inscritas en esta plataforma para hacer que las operaciones comerciales que se realicen por este medio sean lo más transparentes y seguras posibles. adicional a esto cada usuario debe ser calificado al terminar cada servicio.',
        'Si, solo basta definir el punto de inicio donde será prestado el servicio',
        'Alter cuenta con un chat integrado donde se pondrá en contacto al prestador del servicio y al que lo solicita, también será visible su numero de contacto',
        'Podrás calificar al finalizar el servicio y tendrás un espacio en la aplicación donde podrás contarnos tus quejas, solicitudes o dudas',
        'En la aplicación podrás encontrar la opción referidos donde debes  ingresar los datos de la persona a que vas a referir, al cual le llegara un correo notificándole que ya puede ingresar a la aplicación para que proceda a  registrarse.',
        'No, a menos de que el usuario no se halla registrado en la aplicación ',
        'No, a menos de que el referido halla cancelado su cuenta en el Alter, así podrás remplazarlo por otro',
    ];

    const KEYWORDS = [
        'Alter aplicación sirve que es alter como funciona uso dudas',
        'como funciona alter uso nequi como se usa',
        'Dispositivos móviles con sistema operativo IOS, Android, plataforma web y API',
        'ingresos alter como dinero recibir dinero ingreso',
        'bonificacion cuando recibo alter servicios',
        'servicio problema ayuda no llega incumplimiento',
        'pedio averiado problema ayuda no llega afectado robo daño',
        'dinero saldo alter retiro',
        'pago servicio realizar pago proveedor',
        'cancelo cancelacion servicio tarifa minima',
        'obligatorio referir usuarios grupo',
        'varios servicios mismo tiempo',
        'tratamiento de datos personales terminos y coniciones informacion personal',
        'tarifa alter taxi mensajeria',
        'calidad servicio puntuación calificación',
        'servicio dirección diferente',
        'comunicarme proveedor cliente chat celular',
        'novedades preguntas contacto',
        'referido referidos grupo crecimiento agregar',
        'eliminar borrar referido',
        'editar referido',
    ];

}
