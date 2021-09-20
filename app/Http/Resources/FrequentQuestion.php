<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FrequentQuestion extends JsonResource
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
            'question'          => $this->question,
            'answer'            => $this->answer,
            'theme'             => $this->supporTheme->theme,
            'status'            => $this->status,
            'recorder'          => $this->user->name.' '.$this->user->last_name,
            'keywords'          => $this->keywords,
            'created_at'        => $this->created_at,
        ];
    }
}
