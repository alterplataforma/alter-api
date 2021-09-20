<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class Place extends JsonResource
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
            'name'                  => $this->name,
            'city'                  => $this->city->city,
            'id_provider'           => $this->id_user,
            'provider'              => $this->user->name.' '.$this->user->last_name,
            'place_type'            => $this->place_type->category,
            'image'                 => $this->image,
            'address'               => $this->address,
            'longitude'             => $this->longitude,
            'latitude'              => $this->latitude,
            'headquarter'           => $this->headquarter ? 'Sede principal':'Sede',
            'register_type'         => $this->register_type ? 'App':'Scraping',
            'product_charge'        => $this->product_charge,
            'proprietor_name'       => $this->proprietor_name,
            'since'                 => $this->place_schedule->since,
            'since_type'            => $this->place_schedule->since_type,
            'until'                 => $this->place_schedule->until,
            'until_type'            => $this->place_schedule->until_type,
            'type_schedule'         => $this->place_schedule->type_schedule,
            'approved'              => 'approved',
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at,
        ];
    }

    // private function __make_dist(){
    //     $coordinate1 = new Coordinate($this->longitude, $this->longitude);
	// 	$coordinate2 = new Coordinate($latusuario, $lngusuario);
	// 	$dist =  $coordinate1->getDistance($coordinate2, new Haversine());
    // }
}
