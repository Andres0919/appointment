<?php

namespace App\Http\Controllers\Transaciones;

use App\Modelos\Transacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TransacionController extends Controller
{
    public function all()
    {
        $transacion = Transacion::where('Estado_id', 1)
        ->get();
        return response()->json($transacion, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Nombre' => 'required|string|unique:Transacions',
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        $transacion = Transacion::create($input);
        return response()->json([
            'message' => 'Transacion creado con exito!'
        ], 201);
    }

    public function update(Request $request, Transacion $transacion)
    {
        $transacion->update($request->all());
        return response()->json([
            'message' => 'Transacion actualizado con exito!'
        ]);
    }

    public function available(Request $request, Transacion $transacion)
    {
        $transacion->update([
            'Estado' => $request->Estado
        ]);
        return response()->json([
            'message' => 'Transacion inhabilitado con exito!'
        ], 200);
    }
}
