<?php

namespace App\Models;

use App\Models\Location\City;
use Database\Factories\AddressFavoriteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class FavoriteAddress extends Model
{
    use HasFactory, Notifiable;

    // desactivar una dirección favorita
    const DESACTIVE = 0;

    protected $table = 'favorite_addresses';


    protected $fillable = [
        'id_user', 'title', 'address', 'id_city',
        'indications','latitude','longitude','status'
    ];

    // un usuario posee muchas direcciones favoritas
    public function user() {
        return $this->belongsTo(User::class,'id_user');
    }

    public function city() {
        return $this->belongsTo(City::class,'id_city');
    }

    // usando factory
    protected static function newFactory(): AddressFavoriteFactory {
        return AddressFavoriteFactory::new();
    }
}
