<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle_type extends Model
{
    use HasFactory;

    protected $table = 'vehicle_types';

    const TYPE = [
        'Automovil',
        'Moto',
        'Camioneta',
        'Bicicleta',
        'Taxi',
        'Domicilio',
    ];

    public function user() {
        return $this->belongsTo(User::class,'id_user');
    }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class,'id_vehicle_type');
    }


}
