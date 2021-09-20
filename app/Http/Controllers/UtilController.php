<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Env;

class UtilController extends Controller
{
    protected $apis;
    protected $key;
    protected $agent;

    public function __construct(){
        $this->apis     = env('GOOGLE_APIS', '');
        $this->key      = env('GOOGLE_KEY', '');
        $this->agent    = env('AGENT', '');
    }

    public function google(Request $request){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, $this->agent);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $url = $this->apis.urlencode($request->start)."&destination=".urlencode($request->end).$this->key;
        curl_setopt($ch, CURLOPT_URL,$url);
        $result=curl_exec($ch);
        $array = json_decode($result, true);
        curl_exec($ch);

        return response()->json([
            'data' => $array
        ]);
    }
}
