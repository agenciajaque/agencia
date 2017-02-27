<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AppDivisione
 */
class AppDivisione extends Model
{
    protected $table = 'app_divisiones';

    protected $primaryKey = 'id_division';

	public $timestamps = false;

    protected $fillable = [
        'nombre_division'
    ];

    protected $guarded = [];

        
}