<?php

namespace App\Http\Controllers;

use App\Models\UnitMeasure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitMeasureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = UnitMeasure::orderBy('created_at','desc')->get();
        return datatables()->of($data)->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, UnitMeasure $unit_meansure)
    {
        $input = $request->all();
        $input['id_user'] =  Auth::user()->id;

          $unit_meansure->create([
            'description' => $input['description'],
            'id_user' => $input['id_user']
          ]);

        return response()->json(['menssage' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitMeasure $unitMeasure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id,Request $request, UnitMeasure $unitMeasure)
    {
      $unitMeans_model = $unitMeasure->where('id',$id)->first();
      $unitMeans_model->update($request->all());
      return response()->json(['menssage' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id,UnitMeasure $unitMeasure)
    {
        $unitMeans_model = $unitMeasure->where('id',$id)->first();
        $unitMeans_model->delete();
        return response()->json(['menssage' => 'success']);
    }
}
