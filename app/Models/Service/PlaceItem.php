<?php

namespace App\Models\Service;

use App\Http\Helpers\UtilHelper;
use App\Models\User;
use Database\Factories\PlaceItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceItem extends Model
{
    use HasFactory;

    protected $table = 'place_items';

    protected $fillable = [
        'title', 'image', 'value', 'extras', 'aproved',
        'customizable', 'id_place', 'id_category_service',
    ];

    const APPROVED          = '1';
    const EXTRAS            = '1';
    const CUSTOMIZABLE      = '1';

    static function search_item($id){
        return PlaceItem::where('id_place',$id)
                        ->where('aproved',PlaceItem::APPROVED);
    }

    static function search_item_title($name){
        return PlaceItem::where('title','like','%'.$name.'%')
                        ->where('approved', PlaceItem::APPROVED)
                        ->where('status',   UtilHelper::AVAILABLE);
    }

    public function place() {
        return $this->belongsTo(Place::class,'id_place');
    }

    public function user() {
        return $this->belongsTo(User::class,'id_user');
    }

    public function category_service() {
        return $this->belongsTo(CategoryService::class,'id_category_service');
    }

     // usando factory
     protected static function newFactory(): PlaceItemFactory {
        return PlaceItemFactory::new();
    }
}
