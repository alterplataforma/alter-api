<?php

namespace App\Http\Helpers;

use App\Mail\CashRetirementMail;
use App\Mail\ShippingPinMail;
use App\Models\Recommendation;
use App\Models\Service\AlterConfiguration;
use App\Models\Service\Service;
use App\Models\Service\ServiceState;
use App\Models\Service\Transaction;
use App\Models\User;
use Hamcrest\Util;
use Illuminate\Support\Facades\Mail;

class UtilHelper {

    const AVAILABLE     = '1';
    const NOT_AVAILABLE = 0;


    public function __construct(){

	}

    //envío de email a retiro de dinero
    static function sendEmail($type, $email, $data){
        switch ($type) {
            case 'pin':
                Mail::to($email)->send(new ShippingPinMail($data['name'], $data['document'], $data['pin'], $type));
                break;
            case 'retirement':
                Mail::to($email)->send(new CashRetirementMail($data['value'], $data['date'], $type));
                break;
            default:
                break;
        }

    }

    //notifación de envio de dinero
    static function send_Notification_user($tokenfcm, $value){
        $json_data = [
            "to" => $tokenfcm,
            "notification" => [
                "body" => "Te han enviado $value a traves de Alter.",
                "title" => "Alter Envio de dinero.",
                "icon" => "https://alterclub.com/icon.png",
            ],
            "data" => [
                "message"=>"ANYTHING EXTRA HERE",
                "picture"=>"http://36.media.tumblr.com/c066cc2238103856c9ac506faa6f3bc2/tumblr_nmstmqtuo81tssmyno1_1280.jpg",
            ]
        ];

        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=AAAAaRYi1uw:APA91bF9PgDmd5bopgxfkEkMJawdN8aERwSlgBuMWNNSgRpiLq0pTLZOJG8NgRjjxOsWLEyL8kqXtQpRnulAlIQjr475iE6UwI80uWFdTOCOOQLKOQ1wuV8fxC91JUZXEmWM51fvlaNFNXrcS09NRuTcEui67DjC0w'
        );

        $data = json_encode($json_data);

        $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $url = "https://fcm.googleapis.com/fcm/send";
        curl_setopt($ch, CURLOPT_URL,$url);
        $result = curl_exec($ch);

        curl_close($ch);
    }

    static function filter($data, $model){

        if(isset($data['desde']) && isset($data['hasta'])){
            $model->whereDate('created_at', '>=', $data['desde'])
                  ->whereDate('created_at', '<=', $data['hasta']);
        }else{
            if(isset($data['desde'])){
                $model->whereDate('created_at', $data['desde']);
            }
            if(isset($data['hasta'])){
                $model->whereDate('created_at', $data['hasta']);
            }
        }
        return $model;
    }

    static function __make_value($value){
        $cofiguration = AlterConfiguration::all()->first();

        $value_group = $value * $cofiguration->group_contribution;
        $service_alter = $value * $cofiguration->alter_service;
        $service_alter = $service_alter + ($service_alter * $cofiguration->iva);
        $transactional_expenses = ($value + $service_alter + $value_group) *  $cofiguration->nequi_commission;
        $cash = round(($value_group + $service_alter + $transactional_expenses) * 2);
        return $cash;
    }

    static function calculate_date_alter_configuration(){
        $cofiguration = AlterConfiguration::all()->first();

        switch ($cofiguration->cut_date_periodicity) {

            case AlterConfiguration::SEMANAL:

                switch ($cofiguration->cut_date_day_week) {
                    case AlterConfiguration::DOMINGO:
                        $dia = "Domingo";
                        $day = "sunday";
                        break;
                    case AlterConfiguration::LUNES:
                        $dia = "Lunes";
                        $day = "monday";
                        break;
                    case AlterConfiguration::MARTES:
                        $dia = "Martes";
                        $day = "tuesday";
                        break;
                    case AlterConfiguration::MIERCOLES:
                        $dia = "Miercoles";
                        $day = "wednesday";
                        break;
                    case AlterConfiguration::JUEVES:
                        $dia = "Jueves";
                        $day = "thursday";
                        break;
                    case AlterConfiguration::VIERNES:
                        $dia = "Viernes";
                        $day = "friday";
                        break;
                    case AlterConfiguration::SABADO:
                        $dia = "Sabado";
                        $day = "saturday";
                        break;
                    default:
                        # code...
                        break;
                }
			    $cutDateText = "Semanal: El dia: ".$dia;

                $lastday 	 = strtotime("last $day");
                $cutDateLast = date("Y-m-d",$lastday);

                if(date("w") == $cofiguration->cut_date_day_week){
                    $cutDate  = date("Y-m-d");
                }else{
                    $nextday 	 = strtotime("next $day");
                    $cutDate  = date("Y-m-d",$nextday);
                }

                break;
            case AlterConfiguration::QUINCENAL:

                $cut_date_initial = $cofiguration->cut_date_initial < 10 ? '0'.$cofiguration->cut_date_initial : $cofiguration->cut_date_initial;
                $cut_date_end     = $cofiguration->cut_date_end < 10 ? '0'.$cofiguration->cut_date_end : $cofiguration->cut_date_initial;

			    $cutDateText = "Desde $cut_date_initial /".date("m/Y")." Hasta  $cut_date_end/".date("m/Y");

                if(date("Y-m-d") == date("Y-m-").$cut_date_initial){
                    $cutDate    = date("Y-m-").$cut_date_initial;
                }elseif(date("Y-m-d") == date("Y-m-").$cut_date_end){
                    $cutDate    = date("Y-m-").$cut_date_end;
                }elseif(date("Y-m-d") < date("Y-m-").$cut_date_initial){
                    echo "test";
                    $cutDate    = date("Y-m-").$cut_date_initial;
                }else{
                    $cutDate    = date("Y-m-").$cut_date_end;
                }
                break;
            case AlterConfiguration::MENSUAL:

                $cutDateText    = "Desde $cofiguration->cut_date_day_month/".date("m/Y", strtotime('-1 months'))." Hasta $cofiguration->cut_date_day_month/".date("m/Y");
                $cutDateLast    = date("Y-m-", strtotime("-1 months")).$cofiguration->cut_date_day_month;

                if(date("Y-m-d") == date("Y-m-").$cofiguration->cut_date_day_month){
                    $cutDate  = date("Y-m-d");
                }elseif(date("Y-m-d") < date("Y-m-").$cofiguration->cut_date_day_month){
                    $cutDate  = date("Y-m-").$cofiguration->cut_date_day_month;
                }else{
                    $cutDate  = date("Y-m-", strtotime('+1 months')).$cofiguration->cut_date_day_month;
                }

                break;
            default:
                break;
        }
        return [
            'cutDateText'    => $cutDateText,
            'cutDate'        => $cutDate,
            'cutDateLast'    => $cutDateLast ? $cutDateLast : null,
        ];
    }

    static function caclulate_balance($user){
        if (date('Y-m-d') == UtilHelper::calculate_date_alter_configuration()['cutDateLast']) {
           $balance = UtilHelper::caclulate_balance_available($user, true);
        }else{
           $balance = UtilHelper::caclulate_balance_available($user, false);
        }
       return $balance;
    }

    static function caclulate_balance_available($user, $with_goal){
        // Saldo que ha ganado por servicios como proveedor
        $total_provider         = UtilHelper::calculate_value_total_user('id_provider', $user->id);
        //Servicios como Cliente
        $total_client           = UtilHelper::calculate_value_total_user('id_client', $user->id);
        $value_provider         = UtilHelper::balance_to_provider($user->id);
        $total_provider         = $total_provider + $value_provider;
        $group_contribution     = UtilHelper::group_contribution($user->id)['son_value']
                                + UtilHelper::group_contribution($user->id)['grandchildren_value']
                                + UtilHelper::group_contribution($user->id)['great_grandchildren_value'];
        if($with_goal) $goal    = UtilHelper::goal_contribution($user->id)['son']
                                + UtilHelper::goal_contribution($user->id)['grandchildren']
                                + UtilHelper::goal_contribution($user->id)['great_grandchildren'];
        else $goal              = 0;

        $service_total = $total_provider + $total_client;

        if($service_total >= $user->metaquincenal){
            $income_total = $total_provider + $group_contribution + $goal;
        }else {
            $income_total = $total_provider;
        }

        return [
            'income_total'      => $income_total,
            'income_group'      => $with_goal ? $group_contribution += $goal : $group_contribution,
            'goal'              => $goal,
            'total_provider'    => $total_provider,
            'total_client'      => $total_client,
            'with_goal'         => $with_goal,
        ];

    }

    static function calculate_value_total_user(string $user, $id){
        $services = UtilHelper::service_calculate($user, $id, ServiceState::VALUE_SERVICE_STATE['Proveedor Finalizado']);
        $total = 0;
        foreach ($services->get() as $service) {
            $value = Transaction::where('id_service',$service->id)->first();
            switch ($user) {
                case 'id_client':
                    if ($value) {
                        $total = $total + $value->total_client;
                    }
                    break;
                case 'id_provider':
                    if ($value) {
                        $total = $total + $value->total_provider;
                    }
                    break;
                default:
                    break;
            }
        }
        return $total;
    }

    static  function service_calculate($user, $id, $state){
        $service = Service::service_provider($user, $id, $state);
        return UtilHelper::filter_to_date($service);
    }

    static function filter_to_date($model){
        $data = [
            'hasta' => date("Y-m-d 23:59:59"),
            'desde' => UtilHelper::calculate_date_alter_configuration()['cutDateLast']
        ];
        return $model =  UtilHelper::filter($data, $model);
    }

	//Saldo que ha ganado por servicios como proveedor
    static function balance_to_provider($id){
        $value_provider  = UtilHelper::service_calculate('id_client', $id, ServiceState::VALUE_SERVICE_STATE['Cobrado']);
        $total           = 0;
        foreach ($value_provider->get() as $value) {
            $total = $total + $value->value;
        }
        return $total;
    }

    // aporte por grupo
    static function group_contribution($id){
        $great_grandchildren_value = 0;
        $son_value                 = 0;
        $grandchildren_value       = 0;
        $sons                      = Recommendation::find_family($id);
        $config                    = AlterConfiguration::all()->first();
        $state                     = ServiceState::VALUE_SERVICE_STATE['Finalizado'];

        foreach ($sons as $son) {
            $son_value = $son_value + Service::find_family_value_service($son, $state);
            foreach (Recommendation::find_family($son->id_user) as $grandchildren) {
                $grandchildren_value = $grandchildren_value + Service::find_family_value_service($grandchildren, $state);
                foreach (Recommendation::find_family($grandchildren->id_user) as $great_grandchildren) {
                    $great_grandchildren_value = $great_grandchildren_value + Service::find_family_value_service($great_grandchildren, $state);
                }
            }
        }

        return [
            'son_value'                 => $son_value                  * $config->son_contribution,
            'grandchildren_value'       => $grandchildren_value        * $config->grandchildren_contribution,
            'great_grandchildren_value' => $great_grandchildren_value  * $config->great_grandchildren_contribution,

        ];
    }

    // aporte por cumplir meta
    static function goal_contribution($id){
        $son_contribution                   = 0;
        $grandchildren_contribution         = 0;
        $great_grandchildren_contribution   = 0;
        $sons                               = Recommendation::find_family($id);

        foreach ($sons as $son) {
            $son_contribution = $son_contribution + UtilHelper::goal_contribution_to_function($son->id_user) * Recommendation::PERCENTAGE;

            foreach (Recommendation::find_family($son->id_user) as $grandchildren) {
                $grandchildren_contribution = $grandchildren_contribution + UtilHelper::goal_contribution_to_function($grandchildren->id_user) * Recommendation::PERCENTAGE;

                foreach (Recommendation::find_family($son->id_user) as  $great_grandchildren) {
                    $great_grandchildren_contribution = $great_grandchildren_contribution + UtilHelper::goal_contribution_to_function($great_grandchildren->id_user) * Recommendation::PERCENTAGE;
                }
            }
        }

        return [
            'son'                   => $son_contribution,
            'grandchildren'         => $grandchildren_contribution,
            'great_grandchildren'   => $great_grandchildren_contribution,
        ];
    }

    static function goal_contribution_to_function($id){
        $user = User::__user($id);
        if (!$user->cumplemeta) {
            return UtilHelper::group_contribution($id)['son_value'] + UtilHelper::group_contribution($id)['grandchildren_value'] + UtilHelper::group_contribution($id)['great_grandchildren_value'];
        }
    }

}
