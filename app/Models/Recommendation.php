<?php

namespace App\Models;

use App\Models\Service\Service;
use Database\Factories\RecomendationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    protected $table = 'recommendations';

    protected $fillable = [
        'id_user','id_recomendado'
    ];

    const NO_REGISTER = 0;
    const REGISTER    = 1;
    const CANCELLED   = 2;

    const PERCENTAGE  = 0.5;

    // buscar hijos, nietos y bisnietos que pertenezcan a un usuario
    static function find_family($id){
        return Recommendation::where('id_recomendado',$id)->where('status', Recommendation::REGISTER)->get();
    }

    // relación con usuario que a quien recomiendan
    public function user() {
        return $this->belongsTo(User::class,'id_user');
    }

    // relación con usuario que recomienda
    public function recommeded() {
        return $this->belongsTo(User::class,'id_recomendado');
    }

    // usando factory
    protected static function newFactory(): RecomendationFactory {
        return RecomendationFactory::new();
    }

}
