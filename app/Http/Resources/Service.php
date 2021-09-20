<?php

namespace App\Http\Resources;

use App\Models\Service\AlterConfiguration;
use App\Models\Service\Payment_type;
use App\Models\Service\ServiceAddress;
use App\Models\Service\ServiceType;
use App\Http\Resources\ServiceAddress as ResourceServiceAddress;
use Illuminate\Http\Resources\Json\JsonResource;

class Service extends JsonResource
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
            'client'                    => $this->client->name.' '.$this->client->last_name,
            'incluyetramite'            => $this->incluyetramitel,
            'state'                     => $this->state->state,
            'colour'                    => $this->state->colour,
            'finish_date'               => $this->finish_date,
            'value'                     => $this->value,
            'value_total'               => $this->__maka_value()['value_total'],
            'provider'                  => $this->provider->name.' '. $this->provider->last_name,
            'isClient'                  => $this->__maka_value()['isCliente'],
            'finish_date'               => $this->finish_date,
            'service_type'              => $this->service_type->service_type,
            'vehicle_type'              => $this->vehicle->vehicle_type->vehicle_type,
            'payment_type'              => $this->payment_type->payment_type,
            'created_at'                => $this->created_at,
            'address'                   => new ResourceServiceAddress(ServiceAddress::where('id_service',$this->id)->first()),
        ];
    }

    // obtener valor total
    private function __maka_value(){
        $isCliente = false;

        if ($this->client->id == \request()->user()->id ) {
            $isCliente = true;
        }

        $cofiguration = AlterConfiguration::all()->first();

        $value_group = $this->value * $cofiguration->group_contribution;
        $service_alter = $this->value * $cofiguration->alter_service;
        $service_alter = $service_alter + ($service_alter * $cofiguration->iva);
        $transactional_expenses = ($this->value + $service_alter + $value_group) *  $cofiguration->nequi_commission;

        if ($this->id_client == $this->id_provider) {
            if($this->id_payment_type == Payment_type::VALUETYPE['Efectivo']){
				$value_total  = round($this->value + $value_group + $service_alter + $transactional_expenses);
            }else{
				$value_total  = round($this->value - $value_group - $service_alter - $transactional_expenses);
            }
        }else{
			$value_total  = round($this->value + $value_group + $service_alter + $transactional_expenses);
        }

        if($this->id_service_type == ServiceType::VALUESERVICE['Domicilios']){
            $value_total  = round($this->value + $this->estimated_total);
        }
        return [
            'value_total'   => $value_total,
            'isCliente'   => $isCliente,
        ];
    }
}
