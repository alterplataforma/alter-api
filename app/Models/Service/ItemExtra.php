<?php

namespace App\Models\Service;

use App\Models\User;
use Database\Factories\ItemExtraFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemExtra extends Model
{
    use HasFactory;

    protected $table = 'item_extras';

    protected $fillable = [
        'name','aproved','id_place_item','id_user','status'
    ];

    public function placeItem() {
        return $this->belongsTo(PlaceItem::class,'id_place_item');
    }

    public function user() {
        return $this->belongsTo(User::class,'id_user');
    }

    // usando factory
    protected static function newFactory(): ItemExtraFactory {
        return ItemExtraFactory::new();
    }

}
