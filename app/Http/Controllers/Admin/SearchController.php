<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlaceCollection;
use App\Http\Resources\SearchItemCollection;
use App\Models\Service\Place;
use App\Models\Service\PlaceItem;
use Illuminate\Http\Request;

class SearchController extends ApiController
{
    protected $place;
    protected $place_item;

    public function __construct(PlaceItem $place_item, Place $place){
        $this->place      = $place;
        $this->place_item = $place_item;
    }

    public function search_place_items(Request $request){
        return response()->json([
            'items'     => new SearchItemCollection($this->place_item::search_item($request->id_place)->orderBy('id')->get())
        ]);
    }

    //buscar productos y tiendas
    public function search_place_product(Request $request){
        return response()->json([
            'stores'     => new PlaceCollection($this->place::search_place($request->busqueda)->orderBy('id')->get()),
            'products'   => new SearchItemCollection($this->place_item::search_item_title($request->busqueda)->orderBy('id')->get()),
        ]);
    }
}
