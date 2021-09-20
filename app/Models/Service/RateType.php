<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateType extends Model
{
    use HasFactory;

    protected $table = 'rate_types';

    protected $fillable = [
        'rate', 'status',
    ];

    const TYPE = [
        'Tarifa normal',
        'Tarifa minima',
        'Banderazo',
    ];

    const TYPE_VALUE = [
        'Tarifa normal' => 1,
        'Tarifa minima' => 2,
        'Banderazo'     => 3,
    ];
}
