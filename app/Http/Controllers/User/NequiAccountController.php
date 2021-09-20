<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\NequiAccountRequest;
use App\Http\Resources\NequiAccount as ResourcesNequiAccount;
use App\Models\NequiAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// incluyendo archivo de php para conexión a nequi
require_once(base_path('app/Http/apinequi/nequiAPI.php'));

class NequiAccountController extends ApiController
{
    protected $account;

    public function __construct(NequiAccount $account)
    {
        $this->account = $account;
    }

    public function index()
    {
        if ($account = $this->account::where('id_user',\request()->user()->id)->where('state',$this->account::ACTIVE)->first()) {
            return response()->json([
                'account' => new ResourcesNequiAccount($account)
            ]);
        }
        return $this->showMessage('El usuario no tiene cuenta nequi habilitada');
    }

    //enviar inivitación a suscripción
    public function send_invitation_to_account(NequiAccountRequest $request)
    {
        //método que viene del requiere_one nequiAPI.php
        $response = nuevaSuscripcion($request->phone);

        if(!$this->__make_validation_nequi($response)){
            $token = $response['ResponseMessage']['ResponseBody']['any']['newSubscriptionRS']['token'];
            return response()->json([
                'token'     => $token,
                'code'      => 200,
                'response'  => true
            ]);
        }else{
            return $this->__make_validation_nequi($response);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            //método que viene del requiere_one nequiAPI.php
            $response = validarSuscripcion($request->phone, $request->token);

            if(!$this->__make_validation_nequi($response)){
                if($response['ResponseMessage']['ResponseBody']['any']['getSubscriptionRS']['subscription']['status']== "1"){
                    $account = new $this->account($request->all());
                    $account->automatic_debit_token = $request->token;
                    $account->status = $this->account::STATE['Principal'];
                    $account->save();
                    DB::commit();
                    return $this->showMessage('Cuenta registrada exitosamente!');
                }elseif($response['ResponseMessage']['ResponseBody']['any']['getSubscriptionRS']['subscription']['status']== "2"){
                    return $this->showMessage('El usuario cancelo la suscripción');
                }elseif($response['ResponseMessage']['ResponseBody']['any']['getSubscriptionRS']['subscription']['status']== "0"){
                    return $this->showMessage('El usuario no ha aceptado suscripcion todavía');
                }
            }else{
                return $this->__make_validation_nequi($response);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

    private function __make_validation_nequi($response){
		if($response['ResponseMessage']['ResponseHeader']['Status']['StatusCode'] == "0"){
            return false;
        }elseif($response['ResponseMessage']['ResponseHeader']['Status']['StatusCode'] == "20-08A"){
            return $this->showMessage('Esta cuenta no se encuentra registrada en nequi');
        }else{
            return $this->errorResponse('Datos invalidos, por favor verifique o intente má tarde', 500);
        }
    }

    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if ($account = $this->account::find($id)) {
                $account->update([
                    'state' => $this->account::DESACTIVE,
                ]);
                return $this->showMessage('Cuenta Eliminada');
            }
            return $this->showMessage('La cuenta no existe');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 409);
        }
    }
}
