<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banners';

    protected $fillable = ['id_user', 'image', 'url' ];

    const IMAGE = [
        '9099',
        '3858',
        '9027',
        '3476',
        '5119',
        '7782',
    ];
}
