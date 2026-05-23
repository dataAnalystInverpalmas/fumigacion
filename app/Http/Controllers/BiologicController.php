<?php

namespace App\Http\Controllers;

use App\Models\Biologic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BiologicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Biologic::orderBy('created_at','desc')->get();
        return datatables()->of($data)->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Biologic $biologic)
    {
 
        $input = $request->all();
        $input['id_user'] =  Auth::user()->id;

          $biologic->create([
            'description' => $input['description'],
            'id_user' => $input['id_user']

          ]);

        return response()->json(['menssage' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Biologic $biologic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id,Request $request, Biologic $biologic)
    {
      $biologic_model = $biologic->where('id',$id)->first();
      $biologic_model->update($request->all());
      return response()->json(['menssage' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy ($id,Biologic $biologic)
    {
        $biologic_model = $biologic->where('id',$id)->first();
        $biologic_model->delete();
        return response()->json(['menssage' => 'success']);
    }
}
