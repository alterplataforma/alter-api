<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_type extends Model
{
    use HasFactory;

    protected $table = 'payment_types';

    // tipos de pagos
    const TYPE = ['Nequi', 'Tarjeta de credito', 'Saldo Alter', 'Efectivo'];
    const VALUETYPE = [
        'Nequi'              => 1,
        'Tarjeta de credito' => 2,
        'Saldo Alter'        => 3,
        'Efectivo'           => 4
    ];

    public function service() {
        return $this->hasMany(Service::class,'id_payment_type','id');
    }

}
