<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePlace extends Model
{
    use HasFactory;

    protected $table = 'service_places';

    protected $fillable = [
        'id_service', 'id_place'
    ];

    static function save_service_place($service, $place){
        return  ServicePlace::create([
                    "id_service"    => $service,
                    "id_place"      => $place
                ]);
    }

}
