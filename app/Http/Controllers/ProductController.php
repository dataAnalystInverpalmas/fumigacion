<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $data = Product::orderBy('created_at', 'desc')->get();
    return datatables()->of($data)->toJson();
  } 

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request, Product $product)
  {
    $input = $request->all();
    $input['id_user'] =  Auth::user()->id;

    $product->create([
      'nombre' => $input['name'],
      'dosis' => $input['dosis'],
      'valor_unitario' =>  $input['valueUnit'],
      'codigo' => $input['code'],
      'categoria' => $input['Categor'],
      'id_unidad_medida' => $input['id_unidad_medida'],
      'id_tipo_producto' => $input['id_tipo_producto'],
      'id_user' => $input['id_user']
    ]);

    return response()->json(['menssage' => 'success']);
  }

  /**
   * Display the specified resource.
   */
  public function show(Product $product)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update($id, Request $request, Product $product)
  {
    $product_model = $product->where('id', $id)->first();
    $product_model->update($request->all());
    return response()->json(['menssage' => 'success']);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id, Product $product)
  {
    $product_model = $product->where('id', $id)->first();
    $product_model->delete();
    return response()->json(['menssage' => 'success']);
  }
}
