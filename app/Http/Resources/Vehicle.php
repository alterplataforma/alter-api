<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Vehicle extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                                => $this->id,
            'name'                              => $this->vehicle,
            'type_vehicle'                      => $this->vehicle_type->vehicle_type,
            'user'                              => $this->user->name.' '.$this->user->last_name,
            'plate'                             => $this->plate,
            'model'                             => $this->model,
            'brand'                             => $this->brand,
            'engine_number'                     => $this->engine_number,
            'chasis_number'                     => $this->chasis_number,
            'image_registration_front'          => $this->image_registration_front,
            'image_registration_back'           => $this->image_registration_back,
            'expiration_date_soat'              => $this->expiration_date_soat,
            'expiration_date_tecnico'           => $this->expiration_date_tecnico,
            'proprietor_document_number'        => $this->proprietor_document_number,
            'proprietor_name'                   => $this->proprietor_name,
            'status'                            => $this->status,
            'created_at'                        => $this->created_at,
            'updated_at'                        => $this->updated_at,
        ];
    }
}
