<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DefinitionRecet extends Model
{
    use HasFactory; 


    public $table = 'definicion_receta';


    protected $dates = ['deleted_at'];

    public $connection = "mysql2";


    public $fillable = [
        'description',
        'id_tipo_aplicacion',
        'id_user'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'description' => 'string',
        'id_tipo_aplicacion' => 'integer',
        'id_user' => 'integer',

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
/*         'nombre' => 'required',
        'manejo' => 'required',
        'tipo' => 'required',
        'formula' => 'required',
        'hora_inicio' => '' */
    ];
}

