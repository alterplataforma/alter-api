<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlterConfiguration extends Model
{
    use HasFactory;

    protected $table = 'alter_configurations';

    // Fecha corte periodicidad
    const SEMANAL   = 0;
    const QUINCENAL = 1;
    const MENSUAL   = 2;

    // Fecha corte dias de la semana
    const DOMINGO   = 0;
    const LUNES     = 1;
    const MARTES    = 2;
    const MIERCOLES = 3;
    const JUEVES    = 4;
    const VIERNES   = 5;
    const SABADO    = 6;
}
