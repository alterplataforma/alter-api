<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddressFavoriteCollection;
use App\Http\Resources\AddressFavorite as ResourcesAddressFavorite;
use App\Models\FavoriteAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends ApiController
{

    protected $address;

    public function __construct(FavoriteAddress $address)
    {
        // inyectamos la dependencia del modelo
        $this->address = $address;
    }


    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $address = $this->address::create($request->all());
            DB::commit();
            return $this->showOne($address);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $address = $this->address::where('id_user',$id)->where('status',1)->orderBy('title')->get();
        if($address->first()){
            return response()->json([
                'address' => new AddressFavoriteCollection ($address)
            ]);
        }
        return $this->showMessage('El usuario no cuenta con dirección favorita');

    }


    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $address = $this->address::findOrFail($id);

            if ($request->has('title')){
                $address->title = $request->title;
            }
            if ($request->has('address')){
                $address->address = $request->address;
            }
            if ($request->has('id_city')){
                $address->id_city = $request->id_city;
            }
            if ($request->has('indications')){
                $address->indications = $request->indications;
            }
            if ($request->has('latitude')){
                $address->latitude = $request->latitude;
            }
            // validar si se actulizo algo
            if (!$address->isDirty()){
                return $this->errorResponse('Se debe especificar al menos un valor diferente para poder actualizar', 422);
            }
            $address->save();
            DB::commit();
            return response()->json([
                'address' => new ResourcesAddressFavorite($address)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $address = $this->address::findOrFail($id);
            $address->update([
                'status' => $this->address::DESACTIVE,
            ]);
            return $this->showMessage('Dirección Eliminada');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 409);
        }
    }
}
