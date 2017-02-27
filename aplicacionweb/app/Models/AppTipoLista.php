<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AppTipoLista
 */
class AppTipoLista extends Model
{
    protected $table = 'app_tipo_listas';

    protected $primaryKey = 'id_item';

	public $timestamps = false;

    protected $fillable = [
        'tipo_lista'
    ];

    protected $guarded = [];

        
}