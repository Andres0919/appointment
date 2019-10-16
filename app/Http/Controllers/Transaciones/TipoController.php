<?php

namespace App\Http\Controllers\Transaciones;

use App\Modelos\Tipo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TipoController extends Controller
{
    
    public function all()
    {
        $tipo = Tipo::all();
        return response()->json($tipo, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'Nombre' => 'required|string|unique:Tipos'
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        $tipo = Tipo::create($input);
        return response()->json([
            'message' => 'Tipo fue creado con exito!'
        ], 201);
    }
    
    public function update(Request $request, Tipo $tipo)
    {
        $tipo->update($request->all());
        return response()->json([
            'message' => 'Tipo actualizado con exito!'
        ]);
    }

    public function available(Request $request, Tipo $tipo)
    {
        $tipo->update([
            'Estado' => $request->Estado
        ]);
        return response()->json([
            'message' => 'Tipo Actualizado con Exito!'
        ], 200);
    }
}
