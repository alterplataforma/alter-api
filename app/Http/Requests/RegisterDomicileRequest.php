<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterDomicileRequest extends FormRequest
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
            'service.id_service_type'   => 'bail|required|exists:service_types,id',
            'service.id_payment_type'   => 'required|exists:payment_types,id',
            'service.estimated_total'   => 'required|min:3',
            'service.id_vehicle'        => 'required|exists:vehicles,id',
            'service.value'             => 'required|min:3',
            'service.total'             => 'required|min:3',
        ];
    }

    public function messages(){
        return  [
            'service.id_service_type.exists'    => 'El tipo de servicio no existe',
            'service.id_vehicle.exists'         => 'El vehiculo no existe',
            'service.id_payment_type.exists'    => 'El tipo de pago no existe',
        ];
    }
}
