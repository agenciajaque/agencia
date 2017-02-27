<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AppPlanProducto
 */
class AppPlanProducto extends Model
{
    protected $table = 'app_plan_productos';

    public $timestamps = false;

    protected $fillable = [
        'id_relacion',
        'id_plan',
        'id_producto'
    ];

    protected $guarded = [];

        
}