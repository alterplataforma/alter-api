<?php

namespace App\Http\Resources;

use App\Models\Recommendation;
use Illuminate\Http\Resources\Json\JsonResource;

class Recommended extends JsonResource
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
            'id'                    => $this->recommeded->id,
            'name'                  => $this->recommeded->name.' '.$this->recommeded->last_name,
            'sons'                  => $this->where('id_recomendado',$this->recommeded->id)->count(),
            'grandchildren'         => $this->__make_grandchildren()['grandchildren'],
            'great_grandchildren'   => $this->__make_grandchildren()['great_grandchildren'],
        ];
    }

    // buscar nietos y bisnietos
    private function __make_grandchildren(){

        $grandchildren = 0;
        $great_grandchildren = 0;
        $grandchildrens =  $this->where('id_recomendado', $this->id_recomendado)->get();
        foreach ($grandchildrens as $q) {
            $query = $this->where('id_recomendado',$q->id_user)->get();
            $grandchildren = $grandchildren + $query->count() ;
            foreach ($query as $k) {
                $great_grandchildren = $great_grandchildren + $this->where('id_recomendado',$k->id_user)->count();
            }
        }
        return [
            'grandchildren'       => $grandchildren,
            'great_grandchildren' => $great_grandchildren
        ];
    }
}
