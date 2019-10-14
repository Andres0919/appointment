<?php

namespace App\Http\Controllers\Sedes;

use App\Modelos\Sede;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SedeController extends Controller
{
    public function all()
    {
        $sede = Sede::all();
        return response()->json($sede, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Nombre'    => 'required|string|unique:sedes|max:90',
            'Direccion' => 'required|string|max:70',
            'Telefono'  => 'required|string|max:50',
            'Nit'       => 'required|string|max:50',
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        $sede = Sede::create($input);
        return response()->json([
            'message' => 'Sede Creada con Exito!'
        ], 201);
    }

    public function show($sede)
    {
        $sede = Sede::find($sede);
        if (!isset($sede)) {
            return response()->json([
                'message' => 'La Sede buscanda no Existe!'
            ], 404);
        }
        return response()->json($sede, 200);
    }

    public function update(Request $request, Sede $sede)
    {
        $sede->update($request->all());
        return response()->json([
            'message' => 'Sede Actualizada con Exito!'
        ], 200);
    }

    public function available(Request $request, Sede $sede)
    {
        $sede->update([
            'Estado_id' => $request->Estado
        ]);
        return response()->json([
            'message' => 'Estado de la Sede Actualizada con Exito!'
        ], 200);
    }

    public function enabled(){
        $sedes = Sede::where('Estado_id', 1)->get();
        return response()->json($sedes, 200);
    }
}
