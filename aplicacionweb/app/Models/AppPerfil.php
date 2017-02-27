<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AppPerfil
 */
class AppPerfil extends Model
{
    protected $table = 'app_perfil';

    public $timestamps = false;

    protected $fillable = [
        'id_perfil',
        'nombre_perfil',
        'fecha_creacion_perfil',
        'id_opcionesxperfil'
    ];

    protected $guarded = [];

        
}