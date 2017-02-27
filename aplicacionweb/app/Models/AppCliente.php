<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AppCliente
 */
class AppCliente extends Model
{
    protected $table = 'app_clientes';

    public $timestamps = false;

    protected $fillable = [
        'id_cliente',
        'nombre_cliente',
        'id_plan',
        'id_perfil',
        'correo_cliente',
        'telefono_cliente'
    ];

    protected $guarded = [];

        
}