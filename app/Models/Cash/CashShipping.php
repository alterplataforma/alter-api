<?php

namespace App\Models\Cash;

use App\Models\User;
use Database\Factories\CashShippingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashShipping extends Model
{
    use HasFactory;

    protected $table = 'cash_shipping';

    const ACTIVE = 1;

    protected $fillable = [
        'id_user_shipping', 'id_user_receive', 'ip', 'value', 'status'
    ];

    static function user_shipping(string $user, $document){
        return cashShipping::where($user, $document)->where('status', cashShipping::ACTIVE);
    }

    public function userShipping() {
        return $this->belongsTo(User::class,'id_user_shipping');
    }

    public function userReceive() {
        return $this->belongsTo(User::class,'id_user_receive');
    }

    protected static function newFactory(): CashShippingFactory {
        return CashShippingFactory::new();
    }
}
