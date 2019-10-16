<?php

namespace App\Http\Controllers\Contratos;

use App\Modelos\Tcontrato;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TcontratoController extends Controller
{
    public function all()
    {
        $tcontrato = Tcontrato::all();
        return response()->jsonp($tcontrato, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Nombre' => 'required|string',
            'Codigo' => 'required|string|unique:tcontratos'
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        $tcontrato = Tcontrato::create($input);
        return response()->json([
            'message' => 'Tipo de contrato creado con Exito!'
        ], 201);
    }
    public function update(Request $request, Tcontrato $tcontrato)
    {
        $tcontrato->update($request->all());
        return response()->json([
            'message' => 'Tcontrato Actualizado con Exito!'
        ], 200);
    }

    public function available(Request $request, Estado $estado)
    {
        $estado->update($request->all());
        return response()->json([
            'message' => 'Estado Actualizado con Exito!'
        ], 200);
    }

    public function enabled(){
        $tcontrato = Tcontrato::where('Estado', 1)->get();
        return response()->json($tcontrato, 200);
    }
}
