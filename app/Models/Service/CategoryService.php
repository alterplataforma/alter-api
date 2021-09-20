<?php

namespace App\Models\Service;

use Database\Factories\CategoryServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryService extends Model
{
    use HasFactory;

    protected $table = 'category_services';

    protected $fillable = [
        'name','id_category','id_place','id_user','status'
    ];

    public function category() {
        return $this->belongsTo(Category::class,'id_category');
    }

    public function place() {
        return $this->belongsTo(Place::class,'id_place');
    }

    // usando factory
    protected static function newFactory(): CategoryServiceFactory {
        return CategoryServiceFactory::new();
    }

}
