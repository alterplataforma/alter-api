<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterDomicileRequest;
use App\Http\Requests\ServiceRequest;
use App\Http\Resources\RateCollection;
use App\Http\Resources\ScoreCollection;
use App\Http\Resources\ServiceCollection;
use App\Http\Resources\Service as ResourceService ;
use App\Models\Service\AlterConfiguration;
use App\Models\Service\ItemDomicile;
use App\Models\Service\Rate;
use App\Models\Service\Score;
use App\Models\Service\Service;
use App\Models\Service\ServiceAddresOrder;
use App\Models\Service\ServiceAddress;
use App\Models\Service\ServicePlace;
use App\Models\Service\ServiceState;
use App\Models\Service\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends ApiController
{
    protected $service;
    protected $configAlter;

    public function __construct(Service $service, AlterConfiguration $configAlter){
        $this->$service     = $service;
        $this->$configAlter = $configAlter;
    }

    public function store(ServiceRequest $request)
    {
        try {
            DB::beginTransaction();

            // guardar el servicio
            $data           = $request->all();
            $data['total']  = $request->value;
            $service        = Service::create($data);

            // guardar las direciones de destino
            if ($request->has('destination_address')) {
                $this-> __save_addres($service->id, $request->destination_address,ServiceAddresOrder::ORDER_VALUE['Direccion de destino']);
            }

            // guardar las direciones de partida
            if ($request->has('departure_direction')) {
                $this-> __save_addres($service->id, $request->departure_direction,ServiceAddresOrder::ORDER_VALUE['Direccion de partida']);
            }

            // validar si trae direciones extras y guardamos
            if ($request->has('address_extras')) {
                foreach ($request->address_extras as $extra) {
                    $this-> __save_addres($service->id, $extra, ServiceAddresOrder::ORDER_VALUE['Direccion extra uno']);
                }
            }
            DB::commit();
            return $this->successResponse($service->id, 'Servicio guardado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

    function __save_addres($id_service, $data, $type){
        $data['id_service']                 = $id_service;
        $data['id_service_addres_order']    = $type;
        ServiceAddress::create($data);
    }


    public function getService(Request $request){
        $service = Service::whereIn('state_id',ServiceState::VALUE_SERVICE_STATE_GETSERVICE);
        $data    = $request->all();

        return response()->json([
            'service' => new ServiceCollection($this->filter($data, $service)->orderBy('id','desc')->get())
        ]);
    }

    public function serviceDetail(Service $service){
        return response()->json([
            'service' => new ResourceService($service)
        ]);
    }

    public function my_service(Request $request){
        $data = $request->all();
        $service = Service::whereIn('state_id', ServiceState::VALUE_SERVICE_STATE_MYSERVICE);

        return response()->json([
            'services' => new ServiceCollection($this->filter($data, $service)->orderBy('id','desc')->get() ),
            'scores'   => new ScoreCollection(Score::where('id_calificado',\request()->user()->id)->get()),//trae la calificación que le han hecho a él usuario
        ]);
    }

    //obtener tarifas
    public function getRate(Request $request){
        $request->validate([
            'id_city'        => 'exists:cities,id',
            'type_vehicle'   => 'exists:vehicle_types,id',
            'type_service'   => 'required|exists:service_types,id',
        ]);

        $rate = Rate::get_rate($request->type_vehicle, $request->type_service, $request->city);

        return response()->json([
            'rate'      => new RateCollection($rate->get()),
            'meter'     => AlterConfiguration::all()->first()['charge_meters'],
            'density'   => AlterConfiguration::all()->first()['traffic_density'],
        ]);
    }


    // cambiar tipo de vehiculo y servico
    public function change_type_vehicle_to_service(Request $request){
        $request->validate([
            'id_service'        => 'required|exists:services,id',
            'id_type_vehicle'   => 'required|exists:vehicle_types,id',
            'id_type_service'   => 'required|exists:service_types,id',
            'value'             => 'min:3'
        ]);

        try {
            DB::beginTransaction();
            // cambiar el tipo de servicio y value
            Service::change_service($request->all());
            // cambiar el tipo de vehiculo
            Vehicle::change_type_vehicle(Service::findOrFail($request->id_service)['id_vehicle'], $request->id_type_vehicle);

            DB::commit();
            return $this->showMessage('Se han generado todos los cambios');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

    public function register_domicile(RegisterDomicileRequest $request){

        try {
            DB::beginTransaction();
            // return $request->service;
            // guardar el servicio
            $data                   = $request->service;
            $data['state_id']       = ServiceState::VALUE_SERVICE_STATE['Activo'];
            $data['id_client']      = \request()->user()->id;
            $service                = Service::create($data);
            // guardar el lugar del servicio
            $service_place          = ServicePlace::save_service_place($service->id, $request->service['id_place']);
            // guardar la dirección de destino
            $this->__save_addres($service->id, $request->service, ServiceAddresOrder::ORDER_VALUE['Direccion de destino']);
            foreach ($request->items as $value) {
                $data               = $value;
                $data['extra']      = 0;
                $data['id_service'] = $service->id;
                $itemDomicile  = ItemDomicile::create($data);
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 409);
        }
    }


    private function filter($data, $service){
        $id = \request()->user()->id;

        if(isset($data['tipo'])){
            if ($data['tipo'] == 1)      $service->where('id_client', $id);
            elseif($data['tipo'] == 2)   $service->where('id_provider', $id);
        }else{
            $service->where(function($q) use($id){
                $q->where('id_client', $id);
                $q->orWhere('id_provider', $id);
            });
        }

        if(isset($data['desde']) && isset($data['hasta'])){
            $service->whereDate('services.created_at', '>=', $data['desde'])
                    ->whereDate('services.created_at', '<=', $data['hasta']);
        }
        else{
            if(isset($data['desde'])){
                $service->whereDate('services.created_at', $data['desde']);
            }
            if(isset($data['hasta'])){
                $service->whereDate('services.created_at', $data['hasta']);
            }
        }
        return $service;
    }
}
