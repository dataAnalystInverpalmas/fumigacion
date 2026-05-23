<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IngredientActiveXProduct extends Model
{
    use HasFactory;
    use SoftDeletes;


    public $table = 'ingrediente_activo_x_product';


    protected $dates = ['deleted_at'];

    public $connection = "mysql2";


    public $fillable = [
        'id_producto',
        'id_ingredient_activ',
        'id_user'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_producto' => 'integer',
        'id_ingredient_activ' => 'integer',
        'id_user'=> 'integer'

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

