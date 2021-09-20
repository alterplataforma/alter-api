<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupportTicket extends JsonResource
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
            'ticket'            => $this->ticket,
            'description'       => $this->description,
            'theme'             => $this->supporTheme->theme,
            'status'            => $this->status,
            'user'              => $this->user->name.' '.$this->user->last_name,
            'created_at'        => $this->created_at,
        ];
    }
}
