<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AppRequerimiento
 */
class AppRequerimiento extends Model
{
    protected $table = 'app_requerimientos';

    public $timestamps = false;

    protected $fillable = [
        'id_requerimiento',
        'id_usuario',
        'fecha_requerimiento',
        'id_cliente',
        'id_producto',
        'fecha_limite_requerimiento',
        'link_adjunto_requerimiento',
        'nota_requerimiento',
        'prioridad_requerimiento',
        'estado_requerimiento'
    ];

    protected $guarded = [];

        
}