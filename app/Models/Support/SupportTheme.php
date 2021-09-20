<?php

namespace App\Models\Support;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTheme extends Model
{
    use HasFactory;

    protected $table = 'support_themes';

    protected $fillable = [
        'theme', 'id_user_register',
    ];

    const THEME = ['Saldo','Uso de la Aplicación'];

    const THEME_VALUE = [
        'Saldo'                  => 1,
        'Uso de la Aplicación'   => 2
    ];

    public function user() {
        return $this->belongsTo(User::class,'id_user_register');
    }
}
