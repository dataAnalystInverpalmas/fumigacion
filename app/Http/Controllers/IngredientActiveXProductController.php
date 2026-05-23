<?php

namespace App\Http\Controllers;

use App\Models\IngredientActiveXProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IngredientActiveXProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $data = IngredientActiveXProduct::join('productos', 'ingrediente_activo_x_product.id_producto', '=', 'productos.id')
        ->join('ingrediente_activo', 'ingrediente_activo_x_product.id_ingredient_activ', '=', 'ingrediente_activo.id')
        ->select('ingrediente_activo_x_product.id as id_ingredient_act_prod',
        'productos.description as producto','id_producto',
        'id_ingredient_activ',
        'ingrediente_activo.description as ingrediente_activo')->orderBy('ingrediente_activo_x_product.created_at','desc')->get();
       return datatables()->of($data)->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, IngredientActiveXProduct $ingredientActiveXProduct)
    {
        $input = $request->all();
        $input['id_user'] =  Auth::user()->id;
        $data_insert = [];
        foreach ($input['ingredients'] as $value) {
            $data = [];
            $data['id_producto'] =  $input['id_producto'];
            $data['id_ingredient_activ'] = $value;
            $data['id_user'] =  $input['id_user'];
            array_push($data_insert,$data );
        }
        $ingredientActiveXProduct->insert($data_insert);



        return response()->json(['menssage' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(IngredientActiveXProduct $ingredientActiveXProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request, IngredientActiveXProduct $ingredientActiveXProduct)
    {
        $ingredient_active_product_model = $ingredientActiveXProduct->where('id', $id)->first();
        $ingredient_active_product_model->update($request->all());
        return response()->json(['menssage' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, IngredientActiveXProduct $ingredientActiveXProduct)
    {
        $ingredient_active_product_model = $ingredientActiveXProduct->where('id', $id)->first();
        $ingredient_active_product_model->delete();
        return response()->json(['menssage' => 'success']);
    }
}
