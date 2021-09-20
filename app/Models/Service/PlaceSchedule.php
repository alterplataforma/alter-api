<?php

namespace App\Models\Service;

use Database\Factories\PlaceScheduleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceSchedule extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'place_schedules';

    protected $fillable = [
        'type_schedule', 'since', 'since_type', 'until', 'until_type',
        'id_place',
    ];

    public function place() {
        return $this->belongsTo(Place::class,'id_place');
    }

     // usando factory
    protected static function newFactory(): PlaceScheduleFactory {
        return PlaceScheduleFactory::new();
    }

}
