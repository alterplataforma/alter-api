<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Recommendeds extends JsonResource
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
            'id'                    => $this->user->id,
            'user'                  => $this->user->name.' '.$this->user->last_name,
            'email'                 => $this->user->email,
            'document'              => $this->user->document_number ,
            'sex'                   => $this->user->sex,
            'city'                  => $this->user->city->city,
            'photo'                 => $this->user->image_user,
            'fecha_registro'        => $this->user->created_at,
        ];
    }
}
