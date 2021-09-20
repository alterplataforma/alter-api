<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceState extends Model
{
    use HasFactory;

    protected $table = 'service_states';

    const SERVICE = [
        'Cancelado',
        'Activo',
        'En proceso',
        'Proveedor Llegó',
        'Proveedor Finalizado',
        'Finalizado',
        'Cobrado',
        'Cancelado Pago Minimo',
        'Sin respuesta',
        'Pago en Efectivo',
        'En proceso del Negocio',
    ];

    const VALUE_SERVICE_STATE = [
        'Cancelado'                 => 1,
        'Activo'                    => 2,
        'En proceso'                => 3,
        'Proveedor Llegó'           => 4,
        'Proveedor Finalizado'      => 5,
        'Finalizado'                => 6,
        'Cobrado'                   => 7,
        'Cancelado Pago Minimo'     => 8,
        'Sin respuesta'             => 9,
        'Pago en Efectivo'          => 10,
        'En proceso del Negocio'    => 11,
    ];

    const VALUE_SERVICE_STATE_GETSERVICE = [2,3,4,5,11,];

    const VALUE_SERVICE_STATE_MYSERVICE = [5,6,7,9,];

    const SERVICE_COLOUR = [
        'red',
        'green',
        'orange',
        'orange',
        'red',
        'red',
        '#c3c302',
        'blue',
        '#c3c302',
        '#c3c302',
        '#c3c302',
    ];
}
