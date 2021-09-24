<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class PlaceController extends Controller
{
    public function show_all() {
        try {
            
            $places = DB::table('places')->where('id_user', Auth::id())->get();

            if ($places == '') {

                $places_prov = array();
                $places_full = array();
                $i = 1;

                foreach ($places as $places) {

                    $id_place = $places->id;

                    $food_full = Place::find($id_place)->food;
                    $liqueur_full = Place::find($id_place)->liqueur;
                    $market_full = Place::find($id_place)->market;
                    $items_full = Place::find($id_place)->items;

                    $places_prov = (array) $places;
                    $places_prov += array(
                        'food' => $food_full,
                        'liqueur' => $liqueur_full,
                        'market' => $market_full,
                        'items' => $items_full,
                    );
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
}
