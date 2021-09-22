<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiqueurCategory extends Model
{
    static $rules = [
        'category'  => 'required|string',
        'id_user'   => 'required|integer',
        'id_place'  => 'required|integer',
    ];

    protected $fillable = [
        'category',
        'id_user',
        'id_place',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function place()
    {
        return $this->belongsTo(Place::class, 'id_place');
    }
}
