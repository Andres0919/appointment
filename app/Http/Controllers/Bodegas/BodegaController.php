<?php

namespace App\Http\Controllers\Bodegas;

use App\Modelos\Bodega;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BodegaController extends Controller
{
    public function all()
    {
        $bodega = Bodega::select(['Bodegas.*', 'Municipios.Nombre as NombreMunicipio', 'Tipobodegas.Nombre as TipobodegaNombre'])
        ->join('Municipios', 'Bodegas.Municipio_id', 'Municipios.id')
        ->join('Tipobodegas', 'Bodegas.Tipobodega_id', 'Tipobodegas.id')
        ->get();
        return response()->json($bodega, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'Nombre' => 'required|string|unique:bodegas'
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        $bodega = Bodega::create($input);
        return response()->json([
            'message' => 'bodega fue creado con exito!'
        ], 201);
    }

    public function update(Request $request, Bodega $bodega)
    {
        $bodega->update($request->all());
        return response()->json([
            'message' => 'bodega actualizado con exito!'
        ]);
    }

    public function available(Request $request, Bodega $bodega)
    {
        $bodega->update([
            'Estado' => $request->Estado
        ]);
        return response()->json([
            'message' => 'bodega Actualizado con Exito!'
        ], 200);
    }
}
