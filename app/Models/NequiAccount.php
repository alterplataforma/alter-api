<?php

namespace App\Models;

use Database\Factories\NequiAccountFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NequiAccount extends Model
{
    use HasFactory;

    protected $table = 'nequi_accounts';

    const DESACTIVE = 0;
    const ACTIVE = 1;

    protected $fillable = [
        'id_user','name',
        'document_number','phone',
        'status','automatic_debit_token','state'
    ];

    const STATE = [
        'Inactivo'  => 0,
        'Activo'    => 1,
        'Principal' => 2,
    ];

    public function user() {
        return $this->belongsTo(User::class,'id_user');
    }

    protected static function newFactory(): NequiAccountFactory {
        return NequiAccountFactory::new();
    }
}
