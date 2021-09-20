<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Rate extends JsonResource
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
            'group_city'            => $this->group_city,
            'city'                  => $this->city,
            'type_city'             => $this->type_city,
            'user'                  => $this->user->name.' '.$this->user->last_name,
            'type_city'             => $this->type_city,
            'value'                 => number_format($this->value),
            'comments'              => $this->comments,
            'title'                 => $this->title,
            'service_type'          => $this->serviceType->service_type,
            'vehicle_type'          => $this->vehicleType->vehicle_type,
            'rate_type'             => $this->rateType->rate,
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at,
        ];
    }
}
