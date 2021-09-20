<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupportAnswer extends JsonResource
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
            'question'          => $this->supportTicket->description,
            'theme'             => $this->supportTicket->supporTheme->theme,
            'status'            => $this->status,
            'ticket'            => $this->supportTicket->ticket,
            'operator'          =>$this->id_operator ? $this->operator->name.' '.$this->operator->last_name:null,

            $this->mergeWhen($this->id_operator, [
                'color'         => '#274b8e',
                'align'         => 'left',
                'fcolor'        => 'white',

            ]),
            $this->mergeWhen($this->id_operator == null, [
                'color'         => '#08c6e8',
                'align'         => 'right',
                'fcolor'        => 'black',

            ]),
            'answer'            => $this->answer,
            'created_at'        => $this->created_at,
        ];
    }
}
