<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
    ];

    // categorias
    const CATEGORY = ['Comida', 'Mercado', 'Licores'];

    const VALUE_CATEGORY = [
        'Comida'        => 1,
        'Mercado'       => 2,
        'Licores'       => 3,
    ];

}
