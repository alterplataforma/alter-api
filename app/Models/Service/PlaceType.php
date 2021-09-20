<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceType extends Model
{
    use HasFactory;

    protected $table = 'place_types';

    const CATEGORY = [
        'Comida',
        'Licores',
        'Mercado',
        'Tiendas de Barrio',
    ];

    const CATEGORY_VALUE = [
        'Comida'            => 1,
        'Licores'           => 2,
        'Mercado'           => 3,
        'Tiendas de Barrio' => 4,
    ];
}
