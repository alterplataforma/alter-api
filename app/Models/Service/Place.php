<?php

namespace App\Models\Service;

use App\Http\Helpers\UtilHelper;
use App\Models\Location\City;
use App\Models\User;
use Database\Factories\PlaceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $table = 'places';

    protected $fillable = [
        'id_place_type', 'id_city', 'id_user', 'name', 'status',
        'description', 'image', 'approved', 'address', 'longitude',
        'latitude', 'headquarter', 'register_type', 'product_charge', 'proprietor_name',
    ];

    const SEDE_PRINCIPAL    = 1;
    const SEDE              = 0;
    const APPROVED          = 1;


    const PLACE_NAME = [
        'Presto',
        'Juan Valdez Café',
        'Kokoriko',
        'La Brasa Roja',
        'McDonalds',
    ];

    const IMAGE = [
        '2276.png',
        'juanvaldez.jpg',
        'kokoriko.png',
        'labrasaroja.jpg',
        'mcdonalds.jpg',
    ];

    static function find_place($id){
        return Place::where('id',$id)
                    ->where('approved',Place::APPROVED);
    }

    static function search_place($name){
        return Place::where('name','like','%'.$name.'%')
                    ->where('approved',Place::APPROVED)
                    ->where('status',UtilHelper::AVAILABLE);
    }

    public function city() {
        return $this->belongsTo(City::class,'id_city');
    }

    public function user() {
        return $this->belongsTo(User::class,'id_user');
    }

    public function place_type() {
        return $this->belongsTo(PlaceType::class,'id_place_type');
    }

    public function place_schedule() {
        return $this->hasOne(PlaceSchedule::class,'id_place');
    }

    // usando factory
    protected static function newFactory(): PlaceFactory {
        return PlaceFactory::new();
    }

}
