<?php

namespace App\Http\Controllers\Historia;

use App\Modelos\Patologia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PatologiaController extends Controller
{
    public function all()
    {
        $patologia = Patologia::Where('Estado', 1)->get();
    }
    
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'Hipertencionarterial' => 'string',
            'Diabetes' => 'string',
            'Isquemicacorazon' => 'string',
            'Coagulacion' => 'string',
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        $patologia = Patologia::create($input);
        return response()->json([
            'message' => 'Patología creada con exito!'
        ], 201);
    }

    
    public function update(Request $request, Patologia $patologia)
    {
        $patologia->update($request->all());
        return response()->json([
            'message' => 'Patología actualizada con exito'
        ], 200);
    }

    public function available(Request $request, Patologia $patologia)
    {
        $patologia->update([
            'Estado_id' => $request->Estado
        ]);
        return response()->json([
            'message' => 'Patología inhabilitada con exito!'
        ], 200);
    }
}
