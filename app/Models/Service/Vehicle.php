<?php

namespace App\Models\Service;

use App\Models\User;
use Database\Factories\VehiclefactoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicles';

    const DESACTIVE = 0;

    protected $fillable = [
        'vehicle', 'id_vehicle_type ', 'id_user ', 'plate',
        'model','brand','chasis_number','engine_number',
        'expiration_date_soat','expiration_date_tecnico','proprietor_document_number','proprietor_name',
        'status',
    ];


    static function change_type_vehicle($id, $id_type){
        Vehicle::where('id',$id)
                ->update([
                    'id_vehicle_type' => $id_type,
                ]);
    }

    public function user() {
        return $this->belongsTo(User::class,'id_user');
    }

    public function vehicle_type() {
        return $this->belongsTo(Vehicle_type::class,'id_vehicle_type','id');
    }

    // usando factory
    protected static function newFactory(): VehiclefactoryFactory {
        return VehiclefactoryFactory::new();
    }
}
