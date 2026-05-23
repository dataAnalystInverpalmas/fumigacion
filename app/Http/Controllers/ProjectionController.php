<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProjectionController extends Controller
{
    public function index()     
    {
       $data = User::get();
       return datatables()->of($data)->toJson();
    }
}
