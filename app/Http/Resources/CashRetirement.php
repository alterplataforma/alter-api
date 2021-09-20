<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CashRetirement extends JsonResource
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
            'user'              => $this->user->name.' '.$this->user->last_name,
            'state'             => $this->state->state,
            'status'            => $this->status,
            'value'             => $this->value,
            'created_at'        => $this->created_at,
        ];
    }
}
