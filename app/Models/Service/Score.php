<?php

namespace App\Models\Service;

use App\Models\User;
use Database\Factories\ScoreFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $table = 'scores';

    public function service() {
        return $this->belongsTo(Service::class,'id_service');
    }

    public function user() {
        return $this->belongsTo(User::class,'id_user');
    }

    // usando factory
    protected static function newFactory(): ScoreFactory {
        return ScoreFactory::new();
    }
}
