<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AppPlane
 */
class AppPlane extends Model
{
    protected $table = 'app_planes';

    public $timestamps = false;

    protected $fillable = [
        'id_plan',
        'nombre_plan',
        'descripcion_plan',
        'id_producto'
    ];

    protected $guarded = [];

        
}