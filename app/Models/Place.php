<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    public function food()
    {
        return $this->hasMany(FoodCategory::class, 'id_place');
    }

    public function liqueur()
    {
        return $this->hasMany(LiqueurCategory::class, 'id_place');
    }

    public function market()
    {
        return $this->hasMany(MarketCategory::class, 'id_place');
    }

    public function items()
    {
        return $this->hasMany(PlaceItem::class, 'id_place');
    }
}
