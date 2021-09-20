<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceAddress extends JsonResource
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
            'id'                    => $this->id,
            'address'               => $this->address,
            'city'                  => $this->city->city,
            'estimated_time'        => $this->estimated_time,
            'indications'           => $this->indications,
            'order'                 => $this->latitude,
            'latitude'              => $this->latitude,
            'longitude'             => $this->longitude,
            'created_at'            => $this->created_at,
        ];
    }
}
