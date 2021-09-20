<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    const COUNTRY = ['Colombia', 'Panamá', 'Venezuela'];

    protected $table = 'countries';



}
