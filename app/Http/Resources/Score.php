<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Score extends JsonResource
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
            'id'                 => $this->id,
            'id_service'         => $this->id_service,
            'user'               => $this->user->name.' '.$this->user->last_name,//usuario que califico el servicio
            'score'              => $this->score,
            'comments'           => $this->comments,
            'type_user'          => $this->type_user,
            'created_at'         => $this->created_at,
        ];
    }
}
