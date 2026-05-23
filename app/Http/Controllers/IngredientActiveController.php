<?php

namespace App\Http\Controllers;

use App\Models\IngredientActive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IngredientActiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = IngredientActive::orderBy('created_at','desc')->get();
       return datatables()->of($data)->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, IngredientActive  $ingredientActive)
    {
        $input = $request->all();
        $input['id_user'] =  Auth::user()->id;

        $ingredientActive->create([
          'description' => $input['description'],
          'id_user' => $input['id_user']
        ]);

      return response()->json(['menssage' => 'success']);
  
    }

    /**
     * Display the specified resource.
     */
    public function show(IngredientActive $ingredientActive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id,Request $request, IngredientActive $ingredientActive)
    {
        $ingredient_active_model = $ingredientActive->where('id',$id)->first();
      $ingredient_active_model->update($request->all());
      return response()->json(['menssage' => 'success']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id,IngredientActive $ingredientActive)
    {
        $ingredient_active_model = $ingredientActive->where('id',$id)->first();
        $ingredient_active_model->delete();
        return response()->json(['menssage' => 'success']);
    }
}
