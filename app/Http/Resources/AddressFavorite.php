<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressFavorite extends JsonResource
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
            'user'                  => $this->user->name.' '.$this->user->last_name,
            'status'                => $this->status,
            'title'                 => $this->title ,
            'address'               => $this->address,
            'city'                  => $this->city->city,
            'indications'           => $this->indications,
            'latitude'              => $this->latitude,
            'longitude'             => $this->longitude,
            'created_at'            => $this->created_at,
        ];
    }
}
