<?php

namespace App\Http\Controllers\Municipios;

use App\Modelos\Municipio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MunicipioController extends Controller
{
    public function all()
    {
        $municipios = Municipio::whereIn("Departamento_id", [1, 12])->get();
        return response()->json($municipios, 200);
    }
}
