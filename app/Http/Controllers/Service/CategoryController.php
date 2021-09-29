<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Service\FoodCategory;
use App\Models\Service\LiqueurCategory;
use App\Models\Service\MarketCategory;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function register_food(Request $request) {
        try {

            $request -> validate(FoodCategory::$rules); 
            
            $category = $request->category;
            $place = $request->id_place;

            if (DB::table('food_categories')
                ->where('category', $category)
                ->where('id_place', $place)
                ->exists()) {
                
                return 'Error: Esa categoría de comida ya está creada';

            } else {

                $food = FoodCategory::create($request->all());
                return 'Ha creado la categoría de comida: ' . $category;

            }

        } catch (\Exception $e) {
            return 'Error: No se ha podido crear la categoría de comida';
        }
    }

    public function register_liqueur(Request $request)
    {
        try {

            $request->validate(LiqueurCategory::$rules);

            $category = $request->category;
            $place = $request->id_place;

            if (DB::table('liqueur_categories')
            ->where('category', $category)
            ->where('id_place', $place)
            ->exists()) {

                return 'Error: Esa categoría de licor ya está creada';
            
            } else {

                $liqueur = LiqueurCategory::create($request->all());
                return 'Ha creado la categoría de licor: ' . $category;
            }

        } catch (\Exception $e) {
            return 'Error: No se ha podido crear la categoría de licor';
        }
    }

    public function register_market(Request $request)
    {
        try {

            $request->validate(MarketCategory::$rules);

            $category = $request->category;
            $place = $request->id_place;

            if (DB::table('market_categories')
            ->where('category', $category)
            ->where('id_place', $place)
            ->exists()) {

                return 'Error: Esa categoría de mercado ya está creada';

            } else {

                $market = MarketCategory::create($request->all());
                return 'Ha creado la categoría de mercado: ' . $category;
            }

        } catch (\Exception $e) {
            return 'Error: No se ha podido crear la categoría mercado';
        }
    }
}
