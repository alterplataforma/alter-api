<?php

namespace App\Http\Resources;

use App\Models\Service\Place;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchItem extends JsonResource
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
            'title'                 => $this->title,
            'image'                 => $this->image,
            'description'           => $this->description,
            'value'                 => number_format($this->calculate_value_items()),
            'extras'                => $this->extras ? 'SÍ':'NO' ,
            'aproved'               => 'Aprovado',
            'customizable'          => $this->customizable ? 'SÍ':'NO',
            'place'                 => $this->place->name,
            'latitud'               => $this->place->latitude,
            'longitud'              => $this->place->longitude,
            'id_place'              => $this->place->id,
            'category'              => $this->category_service->name,
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at,
            'id_user'               => $this->user->id,
            'user'                  => $this->user->name.' '.$this->user->last_name,
            'amount'                => 0,
        ];
    }

    function calculate_value_items(){
        if ($percentage = Place::find_place($this->id_place)->first()) {
            return  $this->value + ($this->value * intval($percentage->product_charge));
        }else{
            return $this->value;
        }
    }
}
