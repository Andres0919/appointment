<?php

namespace App\Http\Controllers\Grupos;

use App\Modelos\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class GrupoController extends Controller
{
    
    public function all()
    {
       $grupos = Grupo::all()
       ->where('Estado_id', 1);
        return response()->json($grupos, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Nombre' => 'required|string|unique:grupos'
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        $grupo = Grupo::create($input);
        return response()->json([
            'message' => 'Grupo creado con exito!'
        ],201);
    }

    public function update(Request $request, Grupo $grupo)
    {
        $grupo->update($request->all());
        return response()->json([
            'message' => 'Grupo actualizado con exito!'
        ], 200);
    }

    public function available(Request $request, Grupo $grupo)
    {
        $grupo->update([
            'Estado_id' => $request->Estado
        ]);
        return response()->json([
            'message' => 'Grupo inhabilitado con exito!'
        ], 200);
    }
}
