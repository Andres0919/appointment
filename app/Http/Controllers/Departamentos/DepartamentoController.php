<?php

namespace App\Http\Controllers\Departamentos;

use App\Modelos\Departamento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartamentoController extends Controller
{
    public function all()
    {
        $departamentos = Departamento::all();
        return response()->json($departamentos, 200);
    }
}
