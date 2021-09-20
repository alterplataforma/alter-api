<?php

namespace App\Models\Service;

use App\Models\User;
use Database\Factories\ItemAddictionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemAddiction extends Model
{
    use HasFactory;

    protected $table = 'item_addictions';

    protected $fillable = [
        'type','title','price','aproved','id_user',
        'id_item_extra','status'
    ];

    public function user() {
        return $this->belongsTo(User::class,'id_user');
    }

    public function ItemExtra() {
        return $this->belongsTo(ItemExtra::class,'id_item_extra');
    }

    // usando factory
    protected static function newFactory(): ItemAddictionFactory {
        return ItemAddictionFactory::new();
    }
}
