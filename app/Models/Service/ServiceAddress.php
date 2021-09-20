<?php

namespace App\Models\Service;

use App\Models\Location\City;
use Database\Factories\ServiceAddressFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAddress extends Model
{
    use HasFactory;

    protected $table = 'service_addresses';

    protected $fillable = [
        'id_service', 'id_city','id_service_addres_order','address',
        'indications', 'latitude','longitude','estimated_time',
    ];

    public function service() {
        return $this->belongsTo(Service::class,'id_service');
    }

    public function city() {
        return $this->belongsTo(City::class,'id_city','id');
    }

    public function addressOrder() {
        return $this->belongsTo(ServiceAddresOrder::class,'id_service_addres_order');
    }

    // usando factory
    protected static function newFactory(): ServiceAddressFactory {
        return ServiceAddressFactory::new();
    }
}
