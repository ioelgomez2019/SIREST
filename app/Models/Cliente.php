<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Cliente del e-commerce (frontend). Se autentica mediante el guard `client`.
 * Antes se llamaba Persona y apuntaba a la tabla `persona`.
 */
class Cliente extends Authenticatable
{
    //use HasApiTokens, HasFactory, Notifiable;
    protected $primaryKey = 'idcliente';

    protected $guard = "client";

    protected $table = "clientes";

    public $timestamps = false;

    protected $fillable = [
        'idcliente',
        'nombres',
        'identificacion',
        'apellidos',
        'telefono',
        'email',
        'password',
        'direccionfiscal',
        'nit',
        'token',
        'status',
    ];

    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute) {
            parent::setAttribute($key, $value);
        }
    }
}
