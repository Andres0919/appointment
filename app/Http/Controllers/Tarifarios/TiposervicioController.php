<?php

namespace App\Http\Controllers\Tarifarios;

use App\Modelos\Tiposervicio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TiposervicioController extends Controller
{

    public function all()
    {
        $tiposervicios = Tiposervicio::all();

        return response()->json($tiposervicios, 200);
    }

    public function store(Request $request)
    {
        Tiposervicio::create($request->all());

        return response()->json([
            'message' => 'Ambito creado con exito!' 
        ], 201);
    }

    public function update(Request $request, Tiposervicio $tiposervicio)
    {
        $tiposervicio->update($request->all());

        return response()->json([
            'message' => 'tipo de cita actualizada'
        ], 200);
    }
}
