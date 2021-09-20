<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NequiAccountRequest extends FormRequest
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
            'name'              => 'bail|min:3|required',
            'document_number'   => 'unique:nequi_accounts|required|min:7',
            'phone'             => 'unique:nequi_accounts|required|min:9',
            'id_user'           => 'unique:nequi_accounts|exists:users,id',
        ];
    }

    public function messages(){
        return  [
            'id_user.unique'    => 'El usuario ya ha registrado una cuenta',
            'id_user.exists'    => 'El usuario no existe',
            'phone.unique'      => 'Este numero de telefono ya tiene una cuenta registrada anteriormente',
        ];
    }
}
