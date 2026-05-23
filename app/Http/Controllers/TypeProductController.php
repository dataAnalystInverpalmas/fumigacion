<?php

namespace App\Http\Controllers;

use App\Models\TypeProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = TypeProduct::orderBy('created_at','desc')->get();
       return datatables()->of($data)->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, TypeProduct $type_product)
    {
        $input = $request->all();
        $input['id_user'] =  Auth::user()->id;

        $type_product->create([
          'description' => $input['description'],
          'id_user' => $input['id_user']

        ]);

      return response()->json(['menssage' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeProduct $typeProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id,Request $request, TypeProduct $type_product)
    {
        $type_product_model = $type_product->where('id',$id)->first();
        $type_product_model->update($request->all());
        return response()->json(['menssage' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id,TypeProduct $typeProduct)
    {
        $typeProduct_model = $typeProduct->where('id',$id)->first();
        $typeProduct_model->delete();
        return response()->json(['menssage' => 'success']);
    }
}
