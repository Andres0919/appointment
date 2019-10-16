<?php

namespace App\Http\Controllers\Historia;

use App\Modelos\Antecedente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AntecedenteController extends Controller
{
    public function all()
    {
        $antecedentes = Antecedente::all();
        return response()->json($antecedentes, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Nombre' => 'string'
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        $antecedente = Antecedente::create($input);
        return response()->json([
            'message' => 'Antecedente creado con exito!'
        ],201);
    }

    public function update(Request $request, Antecedente $antecedente)
    {
        $antecedente->update($request->all());
        return response()->json([
            'message' => 'Antecedente actualizado con exito!'
        ], 200);
    }
}
