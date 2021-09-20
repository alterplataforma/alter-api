<?php

namespace App\Models\Cash;

use App\Models\User;
use Database\Factories\CashRetirementFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRetirement extends Model
{
    use HasFactory;

    protected $table = 'cash_retirement';

    protected $fillable = [
        'id_user', 'id_state', 'value', 'ip', 'status'
    ];

    public function user() {
        return $this->belongsTo(User::class,'id_user');
    }

    public function state() {
        return $this->belongsTo(CashState::class,'id_state');
    }

    protected static function newFactory(): CashRetirementFactory {
        return CashRetirementFactory::new();
    }
}
