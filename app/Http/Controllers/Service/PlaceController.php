<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Service\Place;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class PlaceController extends Controller
{
    public function show_all() {
        try {
            
            //Busca toda la info de los negocios del usuario
            $places = DB::table('places')->where('id_user', Auth::id())->get();

            if (count($places) > 0) {

                $places_prov = array();
                $places_full = array();
                $i = 1;

                foreach ($places as $places) {

                    $id_place = $places->id;

                    //Busca las categorías y productos de cada negocio
                    $food_full = Place::find($id_place)->food;
                    $liqueur_full = Place::find($id_place)->liqueur;
                    $market_full = Place::find($id_place)->market;
                    $items_full = Place::find($id_place)->items;

                    //Llena un array provicional con la info de cada negocio
                    $places_prov = (array) $places;
                    $places_prov += array(
                        'food' => $food_full,
                        'liqueur' => $liqueur_full,
                        'market' => $market_full,
                        'items' => $items_full,
                    );
                    //Se va llenando el array donde están todos los negocios
                    //con cada array provicional completo
                    $places_full += array(
                        "place_$i" => $places_prov,
                    );
                    $i++;
                }
                return response()->json($places_full);
            } else {
                return 'No tiene negocios registrados';
            }
        } catch (\Exception $e) {
            return $e->getMessage();    
        }
    }

    public function register(Request $request) {
        
        try {
            //Valida que los datos se hayan ingresado bien y toma algunos datos útiles
            $request->validate(Place::$rules);
            $name = $request->name;
            $n_sedes = $request->n_sedes;

            //Valida que el negocio no esté registrado
            if (!DB::table('places')
            ->where('name', $name)
            ->exists()) {

                //Se toma el nombre del archivo y se guarda la imagen
                $img_name = $request->image->getClientOriginalName();
                $request->image->move('img', $img_name);

                //Siempre guardará el primer lugar como sede principal
                Place::create($request->except('image') + 
                                ['id_user' => Auth::id(),
                                'headquarter' => Place::SEDE_PRINCIPAL,
                                'image' => $img_name]);

                if ($n_sedes == 1) {
                    return 'Se ha registrado su negocio satisfactoriamente';
                } else {

                    //Loopea entre las diferentes direcciones para crear las sedes
                    for ($i=2; $i <= $n_sedes; $i++) { 
                        
                        $address = $request->input("address_".$i);
                        $longitude = $request->input("longitude_".$i);
                        $latitude = $request->input("latitude_".$i);

                        DB::table('places')->insert([
                            'id_place_type' => $request->id_place_type,
                            'id_city' => $request->id_city,
                            'id_user' => Auth::id(),
                            'name' => $request->name,
                            'description' => $request->description,
                            'image' => $img_name,
                            'address' => $address,
                            'longitude' => $longitude,
                            'latitude' => $latitude,
                            'headquarter' => Place::SEDE,
                            'proprietor_name' => $request->proprietor_name,
                            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
                            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
                        ]);
                    }
                    return 'Se ha registrado su negocio y sedes satisfactoriamente';
                }

            } else {
                return 'Este negocio ya está registrado';
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }    
    }

    public function update(Request $request, $id) {

        try {

            $request->validate(Place::$rules);

            if ($place = Place::find($id)) {

                if ($place->id_user == Auth::id()) {
                    
                    $place->update($request->all());
                    return 'Se ha actualizado la información del negocio';

                } else {
                    return 'Este negocio no es tuyo';
                }
            } else {
                return 'Este negocio no está registrado';
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function delete($id) {
        try {
            if ($place = Place::find($id)) {

                if ($place->id_user == Auth::id()) {

                    $place->delete();
                    return 'Ha eliminado este negocio satisfactoriamente';

                } else {
                    return 'Este negocio no es tuyo';
                }
            } else {
                return 'Este negocio no está registrado';
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
