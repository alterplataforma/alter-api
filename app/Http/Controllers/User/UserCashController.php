<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Helpers\UtilHelper;
use App\Http\Resources\CashRetirementCollection;
use App\Http\Resources\CashShippingCollection;
use App\Http\Resources\ServiceCollection;
use App\Http\Resources\UserAccountState;
use App\Models\Cash\CashRetirement;
use App\Models\Cash\CashShipping;
use App\Models\Cash\CashState;
use App\Models\Service\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserCashController extends ApiController
{
    protected $retirement;
    protected $cashShipping;

    public function __construct(CashRetirement $retirement, CashShipping $cashShipping)
    {
        $this->retirement   = $retirement;
        $this->cashShipping = $cashShipping;

    }

    // retiro dinero
    public function cash_retirement(Request $request){
        $request->validate([
            'ip'           => 'required|min:5|ipv4',
            'value'        => 'required',
        ]);

        try {
            $alter_cash = \request()->user()->alter_cash;

            if($request->value <= $alter_cash){
                $retirement = $this->retirement::create([
                    'id_user'       => \request()->user()->id,
                    'id_state'      => CashState::STATUS_VALUE['Solicitado'],
                    'value'         => $request->value,
                    'ip'            => $request->ip,
                ]);

                // actulizar al usuario con el nuevo valor de su saldo
                $cash = $this->__update_cash_user(\request()->user()->id, $alter_cash, $request->value,'-');

                // envio de correo
                $data = [
                    'value' => number_format($request->value),
                    'date'  => $retirement->created_at,
                ];
                UtilHelper::sendEmail('retirement', \request()->user()->email, $data);
            }else{
                return $this->showMessage('Su saldo actual es de $'.number_format($alter_cash). ', no cuenta con el monto que desea retirar');
            }
            return $this->showMessage('Su transacción quedó programada, su saldo actual es de $'.$cash);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

    //mis retiros
    public function my_retirement(){
        return response()->json([
            'retirement' => new CashRetirementCollection(
                $this->retirement::where('id_user',\request()->user()->id)->where('id_state',CashState::STATUS_VALUE['Solicitado'])->get()
            )
        ]);
    }

    // envío de pin
    public function shipping_cash_pin(Request $request){
        $request->validate([
            'document_number'   => 'required|exists:users,document_number',
        ]);
        $pin = rand(1000,5000);
        try {
            // traer al usuario
            $user =  User::__user($request->document_number);
            //actulizar pin al usuario
            $this->__update_pin_user($pin);
            // enviar pin por correo
            $data = [
                'pin'       => $pin,
                'document'  => $user->document_number,
                'name'      => $user->name.' '.$user->last_name,
            ];
            UtilHelper::sendEmail('pin', \request()->user()->email, $data);
            return $this->showMessage('Se la ha enviado un pin a su correo electronico');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

    // envío de dinero
    public function shipping_cash(Request $request){
        $request->validate([
            'document_number'   => 'required|exists:users,document_number',
            'pin'               => 'required|min:4',
            'value'             => 'required|min:3',
            'ip'                => 'required|min:5|ipv4',
        ]);

        $user       =  User::__user($request->document_number);
        $alter_cash = \request()->user()->alter_cash;

        if ($request->pin == \request()->user()->pin) {
           if ($request->value <= $alter_cash && \request()->user()->id != $user->id) {
                //actulizar el saldo del usuario
                $cash = $this->__update_cash_user(\request()->user()->id, $alter_cash, $request->value,'-');

                // sumarle al otro usuario
                $this->__update_cash_user($user->id, $user->alter_cash, $request->value,'+');

                //insertar en tabla el envio
                $this->__insert_shipping_cash($request->all(), \request()->user()->id);

                // enviar notificacion
                UtilHelper::send_Notification_user($user->tokenfcm, $request->value);

                return $this->showMessage('Todo salío bien, su saldo actual es de $'.$cash);

            }elseif($request->value > $alter_cash){
                return $this->showMessage('No posees saldo suficiente, tu saldo actual es de $'.$alter_cash);
            }else{
                return $this->showMessage('No puedes enviarte dinero a ti mismo');
            }
        }else{
            return $this->showMessage('El pin es incorrecto');
        }
    }

    //mis envios
    public function my_shipping(Request $request){
        try {
            $shipping_me        = UtilHelper::filter($request->all(), $this->cashShipping::user_shipping('id_user_shipping',\request()->user()->document_number));
            $shipping_received  = UtilHelper::filter($request->all(), $this->cashShipping::user_shipping('id_user_receive', \request()->user()->document_number));

            return response()->json([
                'my_shipping'           => new CashShippingCollection($shipping_me->get()),
                'my_shipping_receive'   => new CashShippingCollection($shipping_received->get()),
                'cash_service'          => new ServiceCollection($this->__make_value()->get()),
            ]);

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

    // estado de cuenta
    public function account_state(){
        return response()->json([
            'account_state' => new UserAccountState(\request()->user()),
        ]);
    }

    function __make_value(){
        $services = Service::service_user();
        foreach ($services as $service) {
            $service->value = UtilHelper::__make_value($service->value);
        }
        return $services;
    }

    function __update_cash_user($id, $cash, $value, $type){
        $user = User::findOrFail($id);
        switch ($type) {
            case '-':
                $user->update([
                    'alter_cash' => $cash - $value,
                ]);
                break;
            case '+':
                $user->update([
                    'alter_cash' => $cash + $value,
                ]);
                break;
            default:
                break;
        }
        return number_format($user->alter_cash);
    }


    function __update_pin_user($pin){
        \request()->user()->update([
            'pin' => $pin,
        ]);
    }

    function __insert_shipping_cash($data, $id){
        $this->cashShipping::create([
            'id_user_shipping'      => $id,
            'id_user_receive'       => $data['document_number'],
            'pin'                   => $data['pin'],
            'value'                 => $data['value'],
            'ip'                    => $data['ip'],
        ]);
    }
}
