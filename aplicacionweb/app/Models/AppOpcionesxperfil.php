<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AppOpcionesxperfil
 */
class AppOpcionesxperfil extends Model
{
    protected $table = 'app_opcionesxperfil';

    protected $primaryKey = 'id_opcionesxperfil';

	public $timestamps = false;

    protected $fillable = [
        'nombre_opcionesxperfil',
        'opcion_opcionesxperfil'
    ];

    protected $guarded = [];

        
}