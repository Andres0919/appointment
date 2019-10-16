<?php

namespace App\Http\Controllers\Bodegas;

use App\Modelos\Tipobodega;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class TipobodegaController extends Controller
{
    public function all()
    {
        $tipobodega = Tipobodega::where('Estado_id', 1)
        ->get();
        return response()->json($tipobodega, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'Nombre' => 'required|string|unique:Tipobodegas'
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        $tipobodega = Tipobodega::create($input);
        return response()->json([
            'message' => 'Tipobodega fue creado con exito!'
        ], 201);
    }

    public function update(Request $request, Tipobodega $tipobodega)
    {
        $tipobodega->update($request->all());
        return response()->json([
            'message' => 'Tipobodega actualizado con exito!'
        ]);
    }

    public function available(Request $request, Tipobodega $tipobodega)
    {
        $tipobodega->update([
            'Estado' => $request->Estado
        ]);
        return response()->json([
            'message' => 'Tipobodega Actualizado con Exito!'
        ], 200);
    }
}
