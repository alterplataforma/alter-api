<?php

namespace App\Models\Service;

use App\Http\Helpers\UtilHelper;
use App\Models\User;
use Database\Factories\ServicesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'id_service_type', 'id_vehicle','id_payment_type','id_client',
        'id_provider', 'state_id','incluyetramite','for_cancel',
        'arrival_date', 'finish_date','estimated_time','Time_for_repair',
        'value', 'total','estimated_total','transaction','reference_nequi'
    ];

    static function service_user(){
        return  Service::where('id_client',\request()->user()->id, function($q){
                            $q->orWhere('id_provider',\request()->user()->id);
                        })
                        ->where('id_payment_type',Payment_type::VALUETYPE['Efectivo'])
                        ->whereIn('state_id',[ServiceState::VALUE_SERVICE_STATE['Finalizado'],ServiceState::VALUE_SERVICE_STATE['Sin respuesta']])
                        ->where('value','>',0);
    }

    // buscar el valor del servicio de los hijos, nietos y bisnietos
    static function find_family_value_service($model, $state){
        $service = Service::where('id_client', $model->id_user)
                            ->orWhere('id_provider', $model->id_user)
                            ->where('state_id', $state);

        $service = UtilHelper::filter_to_date($service);
        return $service->sum('value');
    }

    static function change_service($data){
        Service::where('id',$data['id_service'])
                ->update([
                    'id_service_type'   => $data['id_type_service'],
                    'value'             => $data['value'],
                    'total'             => $data['value'],
                ]);
    }

    static function service_provider(string $user, $id, $state){
        return Service::where($user, $id)
                        ->where('state_id', $state);
    }

    public function service_type() {
        return $this->belongsTo(ServiceType::class,'id_service_type');
    }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class,'id_vehicle');
    }

    public function payment_type() {
        return $this->belongsTo(Payment_type::class,'id_payment_type');
    }

    public function state() {
        return $this->belongsTo(ServiceState::class,'state_id');
    }

    public function client() {
        return $this->belongsTo(User::class,'id_client');
    }

    public function provider() {
        return $this->belongsTo(User::class,'id_provider');
    }

    public function score() {
        return $this->hasMany(Score::class,'id','id_service');
    }

    // usando factory
    protected static function newFactory(): ServicesFactory {
        return ServicesFactory::new();
    }

}
