<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleRequest;
use App\Http\Resources\Vehicle as ResourcesVehicle;
use App\Http\Resources\VehicleCollection;
use App\Models\Service\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Util;
use Illuminate\Support\Facades\File;



class VehicleController extends ApiController
{
    protected $vehicle;

    public function __construct(Vehicle $vehicle)
    {
        // inyectamos la dependencia del modelo
        $this->vehicle = $vehicle;
    }


    // retornar todos los vehiculos
    public function index()
    {
        return response()->json([
            'vehicle' => new VehicleCollection($this->vehicle::where('status',1)->orderBy('vehicle')->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // crear un vehiculo
    public function store(VehicleRequest $request)
    {

        try {
            DB::beginTransaction();
            // creamos el vehiculo
            $vehicle = new $this->vehicle($request->all());
            $vehicle->id_user = intval($request->id_user);
            $vehicle->id_vehicle_type = intval($request->id_vehicle_type);
            //validamos  si viene con imagen de ususario
            if($request->hasFile("image_registration_front")){
                $file = $request->file("image_registration_front");
                $name = time().$file->getClientOriginalName();
                $path = $file->move(public_path().'/img/vehicle/', $name);
                $vehicle->image_registration_front = Util::normalizePath($path);
            }
            //validamos  si viene con imagen de ususario
            if($request->hasFile("image_registration_back")){
                $file = $request->file("image_registration_back");
                $name = time().$file->getClientOriginalName();
                $path = $file->move(public_path().'/img/vehicle/', $name);
                $vehicle->image_registration_back = Util::normalizePath($path);
            }

            $vehicle->save();
            DB::commit();
            return $this->showOne($vehicle);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

    // mostrar los vehículos que tienen un usuario
    public function UserVehicle($id){

        return response()->json([
            'vehicle' => new VehicleCollection($this->vehicle::where('id_user',$id)->where('status',1)->orderBy('vehicle')->get())
        ]);
    }

    // traer un vehiculo en especifico
    public function show($id)
    {
        if($vehicle =  $this->vehicle::where('id',$id)->where('status',1)->first()){
            return response()->json([
                'vehicle' => new ResourcesVehicle($vehicle)
            ]);
        }else{
            return $this->showMessage('Este vehiculo no existe o ha sido eliminado');
        }
    }

    // mostrar los tipos de vehiculos
    public function VehicleType($id){
        $vehicle =  $this->vehicle::where('id_vehicle_type',$id)->where('status',1)->orderBy('vehicle')->get();
        if($vehicle->first()){
            return response()->json([
                'vehicle' => new VehicleCollection($vehicle)
            ]);
        }else{
            return $this->showMessage('Este tipo de vehiculo no existe, o no tiene vehiculos asociados');
        }
    }

    // editar vehiculo
    public function edit(Request $request, $id)
    {
        $request->validate([
            'engine_number'    => 'bail|unique:vehicles,engine_number,'.$id,//exceptuar al usuario
            'chasis_number'    => 'unique:vehicles,chasis_number,'.$id,
            'plate'            => 'unique:vehicles,plate,'.$id,
            'id_vehicle_type'  => 'exists:vehicle_types,id'//expecificar que tipo de vehiculo existe
        ]);

        try {
            DB::beginTransaction();

            if ($vehicle = $this->vehicle::where('id',$id)->where('status',1)->first()){
                $vehicle->update($request->all());

                //validamos si va a cambiar el tipo de vehiculo
                if ($request->has('id_vehicle_type')){
                    $vehicle->id_vehicle_type = $request->id_vehicle_type;
                }

                if($request->hasFile("image_registration_front")){
                    File::delete($vehicle->image_registration_front);
                    $file = $request->file("image_registration_front");
                    $name = time().$file->getClientOriginalName();
                    $path = $file->move(public_path().'/img/vehicle/', $name);
                    $vehicle->image_registration_front = Util::normalizePath($path);
                }
                if($request->hasFile("image_registration_back")){
                    File::delete($vehicle->image_registration_back);
                    $file = $request->file("image_registration_back");
                    $name = time().$file->getClientOriginalName();
                    $path = $file->move(public_path().'/img/vehicle/', $name);
                    $vehicle->image_registration_back = Util::normalizePath($path);
                }
                $vehicle->save();
                DB::commit();
                return response()->json([
                    'vehicle' => new ResourcesVehicle($vehicle)
                ]);
            }
            return $this->showMessage('Vehiculo no existe o se ha eliminado');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

    //desactivar vehiculo
    public function destroy($id)
    {
        try {
            $vehicle = $this->vehicle::findOrFail($id);
            $vehicle->update([
                'status' => $this->vehicle::DESACTIVE,
            ]);
            return $this->showMessage('Vehiculo eliminado');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 409);
        }
    }
}
