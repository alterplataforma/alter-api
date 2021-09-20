<?php

namespace App\Models\Location;

use Database\Factories\DepartamentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departament extends Model
{
    use HasFactory;

    protected $table = 'departments';


    // usando factory
    protected static function newFactory(): DepartamentFactory {
        return DepartamentFactory::new();
    }
}
