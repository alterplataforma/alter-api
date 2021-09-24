<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'id'                => $this->id,
            'name'              => $this->name,
            'laste_name'        => $this->last_name,
            'document_number'   => $this->document_number,
            'email'             => $this->email,
            'sex'               => $this->sex,
            'birth_date'        => $this->birth_date,
            'cell_phone'        => $this->cell_phone,
            'address'           => $this->address,
            //'id_city'           => $this->city->id_city,
            'image'             => $this->image_user,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }
}
