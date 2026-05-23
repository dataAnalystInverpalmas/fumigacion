<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;


    public $table = 'productos';


    protected $dates = ['deleted_at'];

    public $connection = "mysql2";


    public $fillable = [
        'nombre',
        'dosis',
        'valor_unitario',
        'codigo',
        'categoria',
        'id_unidad_medida',
        'id_tipo_producto',
        'id_user'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nombre' => 'string',
        'dosis' => 'decimal:2',
        'valor_unitario' => 'decimal:2',
        'codigo' => 'integer',
        'categoria' => 'string',
        'id_unidad_medida' => 'integer',
        'id_tipo_producto' => 'integer',
        'id_user' => 'integer'

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
