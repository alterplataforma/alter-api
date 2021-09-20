<?php

namespace App\Models\Location;

use Database\Factories\CityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';

    protected $fillable = [
        'id', 'city', 'id_department'
    ];

    const CITY = [
        'Todas las ciudades' => 1
    ];

    // relacion de uno a uno usuario con una ciudad
    public function user() {
        return $this->hasOne(User::class);
    }

    public function serviceAddress() {
        return $this->hasMany(ServiceAddress::class,'id_service','id');
    }

    // usando factory
    protected static function newFactory(): CityFactory {
        return CityFactory::new();
    }
}
