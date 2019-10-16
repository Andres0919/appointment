<?php

namespace App\Http\Controllers\Proveedores;

use App\Modelos\Tipoprestador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TipoprestadorController extends Controller
{

    public function all()
    {
        $tipoprestadores = Tipoprestador::select(['tipoprestadors.*'])
                        ->where('tipoprestadors.Estado_id', 1)
                        ->get();
        return response()->json($tipoprestadores, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Nombre' => 'required|string'
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        $tipoprestador = Tipoprestador::create($input);
        return response()->json([
            'message' => 'Tipoprestador creado con exito!'
        ], 201);
    }

    public function update(Request $request, Tipoprestador $tipoprestador)
    {
        $tipoprestador->update($request->all());
        return response()->json([
            'message' => 'Tipoprestador actualizado con exito!'
        ]);
    }

}
