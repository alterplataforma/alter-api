<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NequiAccount extends JsonResource
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
            'id'                         => $this->id,
            'user'                       => $this->user->name.' '.$this->user->last_name,
            'document_number'            => $this->document_number ,
            'phone'                      => $this->phone,
            'automatic_debit_token'      => $this->automatic_debit_token,
            'created_at'                 => $this->created_at,
            'status'                     => $this->when($this->status != null, function () {
                                                if ($this->status == 1) return "Activa";
                                                elseif ($this->status == 2) return "Principal";
                                                else  return "Inactiva";
                                            }),
        ];
    }
}
