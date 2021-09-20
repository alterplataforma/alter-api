<?php

namespace App\Models\Service;

use App\Models\Location\City;
use App\Models\User;
use Database\Factories\RateFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $table = 'rates';

    protected $fillable = [
        'group_city', 'type_city', 'type_calculation', 'value', 'comments',
        'id_service_type', 'id_vehicle_type', 'id_user', 'id_rate_type',
        'title', 'status', 'id_city',
    ];

    // obtener tarifa por nombre de ciudad
    static function get_rate($vehicle, $service, $city){
        return Rate::where('id_vehicle_type', $vehicle)
                    ->where(function($q) use($service){
                        if($service == ServiceType::VALUESERVICE['Taxi de Lujo']){//Si tipo de Servicio es igual a Taxi de lujo se buscan las tarifas de taxi normal
                            $q->where('id_service_type', ServiceType::VALUESERVICE['Taxi']);
                        }else{
                            $q->where('id_service_type', $service);
                        }
                    })
                    ->Join('cities','rates.id_city','cities.id')
                    ->where(function($q) use($city){
                        if('value' != null){
                            $q->where('cities.city','like','%'.$city.'%');
                        }else{
                            $q->where('id_city', City::CITY['Todas las ciudades']);
                        }
                    });
    }

    public function city() {
        return $this->belongsTo(City::class,'id_city');
    }

    public function serviceType() {
        return $this->belongsTo(ServiceType::class,'id_service_type');
    }

    public function vehicleType() {
        return $this->belongsTo(Vehicle_type::class,'id_vehicle_type');
    }

    public function rateType() {
        return $this->belongsTo(RateType::class,'id_rate_type');
    }

    public function user() {
        return $this->belongsTo(User::class,'id_user');
    }

    // usando factory
    protected static function newFactory(): RateFactory {
        return RateFactory::new();
    }
}
