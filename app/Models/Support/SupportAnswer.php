<?php

namespace App\Models\Support;

use App\Models\User;
use Database\Factories\SupportAnswerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportAnswer extends Model
{
    use HasFactory;

    protected $table = 'support_answers';

    protected $fillable = [
        'answer', 'status','id_operator',
        'id_support_ticket'
    ];

    public function operator() {
        return $this->belongsTo(User::class,'id_operator');
    }

    public function supportTicket() {
        return $this->belongsTo(SupportTicket::class,'id_support_ticket');
    }

    // usando factory
    protected static function newFactory(): SupportAnswerFactory {
        return SupportAnswerFactory::new();
    }

}
