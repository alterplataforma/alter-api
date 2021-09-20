<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAddresOrder extends Model
{
    use HasFactory;

    protected $table = 'service_addres_orders';

    protected $fillable = [
        'order', 'status',
    ];

    const ORDER = [
        'Direccion de partida',
        'Direccion de destino',
        'Direccion extra uno',
        'Direccion extra dos',
    ];

    const ORDER_VALUE = [
        'Direccion de partida'  => 1,
        'Direccion de destino'  => 2,
        'Direccion extra uno'   => 3,
        'Direccion extra dos'   => 4,
    ];

}
