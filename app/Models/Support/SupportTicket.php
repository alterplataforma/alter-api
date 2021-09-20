<?php

namespace App\Models\Support;

use App\Models\User;
use Database\Factories\SupportTicketFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $table = 'support_tickets';

    protected $fillable = [
        'description', 'status','id_user',
        'id_support_theme','ticket'
    ];

    public function user() {
        return $this->belongsTo(User::class,'id_user');
    }

    public function supporTheme() {
        return $this->belongsTo(SupportTheme::class,'id_support_theme');
    }

     // usando factory
    protected static function newFactory(): SupportTicketFactory {
        return SupportTicketFactory::new();
    }

}
