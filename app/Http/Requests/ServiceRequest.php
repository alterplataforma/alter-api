<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_service_type'   => 'bail|required|exists:service_types,id',
            'id_vehicle'        => 'required|exists:vehicles,id',
            'id_payment_type'   => 'required|exists:payment_types,id',
            'id_client'         => 'required|exists:users,id',
            'state_id'          => 'required|exists:service_states,id',
            'value'             => 'required|min:3',
            'time_for_repair'   => 'min:2',
        ];
    }

    public function messages(){
        return  [
            'id_service_type.exists'    => 'El tipo de servicio no existe',
            'id_client.exists'          => 'El usuario no existe',
            'id_vehicle.exists'         => 'El vehiculo no existe',
            'id_payment_type.exists'    => 'El tipo de pago no existe',
            'state_id.exists'           => 'El estado no existe',
        ];
    }
}
