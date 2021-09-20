<?php

namespace App\Models;

use App\Models\Location\City;
use App\Models\Location\Departament;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';

    protected $dates = ['deleted_at'];

    //ROLE
    const ADMIN         = 1;
    const USER          = 1;
    const ADMIN_LUGAR   = 1;

    // tipo de sexo
    const MAS = 'M';
    const FEM = 'F';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'document_number', 'last_name',
        'password','id_city','cell_phone','alter_cash','pin'
    ];

    protected $guarded = [];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'idusuario',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    //devolver un uusario por numero de documento
    public static function __user($document){
        return User::where('document_number',$document)->first();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    //relación de un usuario con muchas recomendaciones
    public function recomendation() {
        return $this->hasMany(Recommendation::class);
    }

    // relación de usuario con una ciudad
    public function city() {
        return $this->belongsTo(City::class,'id_city');
    }

    public function favoriteAddress() {
        return $this->hasMany(FavoriteAddress::class,'id_user');
    }

    public function serviceType() {
        return $this->hasMany(ServiceType::class,'id_user');
    }

    public function vehicle_type() {
        return $this->hasMany(Vehicle_type::class);
    }

    public function vehicle() {
        return $this->hasMany(Vehicle::class);
    }

}
