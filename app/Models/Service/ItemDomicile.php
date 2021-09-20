<?php

namespace App\Models\Service;

use Database\Factories\ItemDomicileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemDomicile extends Model
{
    use HasFactory;

    protected $table = 'item_domicile';

    protected $fillable = [
        'amount','extra','instructions','id_place_item','id_service',
        'id_item_addiction','status'
    ];

    public function placeItem() {
        return $this->belongsTo(PlaceItem::class,'id_place_item');
    }

    public function service() {
        return $this->belongsTo(Service::class,'id_service');
    }

    public function itemAddiction() {
        return $this->belongsTo(ItemAddiction::class,'id_item_addiction');
    }

    // usando factory
    protected static function newFactory(): ItemDomicileFactory {
        return ItemDomicileFactory::new();
    }
}
