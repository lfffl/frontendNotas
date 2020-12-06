<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;


class AlumnoController extends Controller
{
    public function index()
    {
        return  DB::select("SELECT * FROM Alumno");
    }
}
