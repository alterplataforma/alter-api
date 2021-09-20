<?php

namespace App\Models\Cash;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashState extends Model
{
    use HasFactory;

    protected $table = 'cash_state';

    const STATUS = [
        'cancelado'  ,
        'Solicitado' ,
        'Efectivo'   ,
        'Rechazado'  ,
    ];

    const STATUS_VALUE = [
        'cancelado'   => 1,
        'Solicitado'  => 2,
        'Efectivo'    => 3,
        'Rechazado'   => 4,
    ];
}
