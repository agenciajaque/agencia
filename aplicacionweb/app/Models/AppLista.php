<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AppLista
 */
class AppLista extends Model
{
    protected $table = 'app_listas';

    public $timestamps = false;

    protected $fillable = [
        'id_lista',
        'id_item',
        'item_lista',
        'valor_lista',
        'fecha_creacion_lista'
    ];

    protected $guarded = [];

        
}