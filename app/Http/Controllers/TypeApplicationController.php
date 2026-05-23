<?php

namespace App\Http\Controllers;

use App\Models\TypeApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = TypeApplication::orderBy('created_at','desc')->get();
       return datatables()->of($data)->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,TypeApplication $type_application)
    {
        $input = $request->all();
        $input['id_user'] =  Auth::user()->id;

        $type_application->create([
          'name' => $input['name'],
          'dosis' => $input['dosis'],
          'valueUnit' => $input['valueUnit'],
          'code' => $input['code'],
          'Categor' => $input['Categor'],
          'id_user' => $input['undMed']

        ]);

      return response()->json(['menssage' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeApplication $typeApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id,Request $request, TypeApplication $typeApplication)
    {
        $type_application_model = $typeApplication->where('id',$id)->first();
        $type_application_model->update($request->all());
        return response()->json(['menssage' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id,TypeApplication $typeApplication)
    {
        $typeApplication_model = $typeApplication->where('id',$id)->first();
        $typeApplication_model->delete();
        return response()->json(['menssage' => 'success']);
    }
}
