<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AppSeguimiento
 */
class AppSeguimiento extends Model
{
    protected $table = 'app_seguimientos';

    public $timestamps = false;

    protected $fillable = [
        'id_seguimiento',
        'id_requerimiento',
        'estado_requerimiento',
        'fecha_seguimiento',
        'comentario_seguimiento',
        'estado_actividad_seguimiento'
    ];

    protected $guarded = [];

        
}