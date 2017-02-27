<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AppProducto
 */
class AppProducto extends Model
{
    protected $table = 'app_productos';

    public $timestamps = false;

    protected $fillable = [
        'id_producto',
        'nombre_producto',
        'descripcion_producto',
        'id_division'
    ];

    protected $guarded = [];

        
}