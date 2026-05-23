<?php

namespace App\Http\Controllers;

use App\Models\BlancoBiolProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlancoBiolProdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
     
        $data = BlancoBiolProduct::join('productos', 'blanco_biolog_x_product.id_producto', '=', 'productos.id')
        ->join('blanco_biologico', 'blanco_biolog_x_product.id_blanco_biolg', '=', 'blanco_biologico.id')
        ->select('blanco_biolog_x_product.id as id_blanco_biolog_prod',
        'productos.nombre as producto','id_producto',
        'id_blanco_biolg',
        'blanco_biologico.description as blanco_biologico')->orderBy('blanco_biolog_x_product.created_at','desc')->get();
       return datatables()->of($data)->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,  BlancoBiolProduct $blancoBiolProduct)
    {
        
        $input = $request->all();
        $input['id_user'] =  Auth::user()->id;
        $data_insert = [];
        foreach ($input['blanco_biol_x_producto'] as $value) {
            $data = [];
            $data['id_producto'] =  $input['id_producto'];
            $data['id_blanco_biolg'] = $value;
            $data['id_user'] =  $input['id_user'];
            array_push($data_insert,$data );
        }
        $blancoBiolProduct->insert($data_insert);



        return response()->json(['menssage' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(BlancoBiolProduct $blancoBiolProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlancoBiolProduct $blancoBiolProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id,BlancoBiolProduct $blancoBiolProduct)
    {
        $blanco_biol_product_model = $blancoBiolProduct->where('id', $id)->first();
        $blanco_biol_product_model->delete();
        return response()->json(['menssage' => 'success']);
    }
}
