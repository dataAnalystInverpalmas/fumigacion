<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Biologic extends Model
{
    use HasFactory;
    use SoftDeletes;


    public $table = 'blanco_biologico';


    protected $dates = ['deleted_at'];

    public $connection = "mysql2";


    public $fillable = [
        'description',
        'id_user'

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'description' => 'string',
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