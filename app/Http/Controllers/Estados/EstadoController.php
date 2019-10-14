<?php

namespace App\Http\Controllers\Estados;

use App\Modelos\Estado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EstadoController extends Controller
{
    public function all()
    {
        $estado = Estado::all();
        return response()->json($estado, 200);
    }

    public function store(Request $request)
    {
        
        $validate = Validator::make($request->all(),[
            'Nombre' => 'required|string|unique:estados',
            'Descripcion' => 'string|max:100',
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        $estado = Estado::create($input);
        return response()->json([
            'message' => 'Estado Creado con Exito!'
        ], 201);
    }

    public function show(Estado $estado)
    {
        $estado = Estado::find($estado);
        if (!isset($estado)) {
            return response()->json([
                'message' => 'El Estado buscado no Existe!'], 404);
        }
        return response()->json($estado, 200);
    }

    public function update(Request $request, Estado $estado)
    {
        $estado->update($request->all());
        return response()->json([
            'message' => 'Estado Actualizado con Exito!'
        ], 200);
    }

    public function available(Request $request, Estado $estado)
    {
        $estado->update($request->all());
        return response()->json([
            'message' => 'Estado Actualizado con Exito!'
        ], 200);
    }
}
