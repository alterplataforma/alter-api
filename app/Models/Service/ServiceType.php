<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    use HasFactory;

    protected $table = 'service_types';

    // tipos de servicios
    const SERVICE = [
        'Mensajería',
        'Taxi',
        'Taxi de Lujo',
        'Compras',
        'Domicilios',
        'Farmacia',
        'Licores',
        'Mercado',
    ];

    const VALUESERVICE = [
        'Mensajería'    => 1,
        'Taxi'          => 2,
        'Taxi de Lujo'  => 3,
        'Compras'       => 4,
        'Domicilios'    => 5,
        'Farmacia'      => 6,
        'Licores'       => 7,
        'Mercado'       => 8,
    ];


    public function user() {
        return $this->belongsTo(User::class,'id_user');
    }

    public function service() {
        return $this->hasMany(User::class,'id_service_type');
    }
}
