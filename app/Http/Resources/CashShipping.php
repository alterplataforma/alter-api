<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CashShipping extends JsonResource
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
            'id'                        => $this->id,
            'user_shipping'             => $this->userShipping->name.' '.$this->userShipping->last_name,
            'id_user_shipping'          => $this->id_user_shipping,
            'user_receive'              => $this->userReceive->name.' '.$this->userReceive->last_name,
            'id_user_receive'           => $this->id_user_receive,
            'ip'                        => $this->ip,
            'status'                    => $this->status,
            'value'                     => number_format($this->value),
            'created_at'                => $this->created_at,
        ];
    }
}
