<?php

namespace App\Http\Controllers\Articulos;

use App\Modelos\Codesumi;
use App\Modelos\Subgrupo;
use Illuminate\Http\Request;
use App\Modelos\Detallearticulo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class DetallearticuloController extends Controller
{
    
    public function all()
    {
        $detallearticulo = Detallearticulo::select(['Detallearticulos.*', 'Subgrupos.Nombre as NombreSubgrupo', 'Codesumis.Codigo as CodigoSumi'])
        ->join('Subgrupos', 'Detallearticulos.Subgrupo_id', 'Subgrupos.id')
        ->join('Codesumis', 'Detallearticulos.Codesumi_id', 'Codesumis.id')
        ->where('Subgrupos.Estado_id', 1)
        ->where('Codesumis.Estado_id', 1)
        ->get();
        return response()->json($detallearticulo, 201);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Cum_Validacion' => 'required|string|unique:Detallearticulos'
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422); 
        }
        $input = $request->all();
        $detallearticulo = Detallearticulo::create($input);
        return response()->json([
            'messages' => 'Detallearticulo creado con exito!'
        ], 201);
    }

    public function update(Request $request, Detallearticulo $detallearticulo)
    {
        $detallearticulo->update($request->all());
        return response()->json([
            'message' => 'Detalle del articulo actualizado con exito!'
        ]);
    }
    
}
