<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
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
            'vehicle'       => 'bail|required|min:3',
            'plate'         => 'required|min:3|unique:vehicles',
            'model'         => 'required|min:3',
            'brand'         => 'required|min:3',
            'chasis_number' => 'required|min:3|unique:vehicles',
            'engine_number' => 'required|min:3|unique:vehicles',
        ];
    }
}
