<?php

namespace App\Http\Controllers\Proveedores;

use App\Modelos\Catalogo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class CatalogoController extends Controller
{
    public function all()
    {
        $catalogo = Catalogo::select(['Catalogos.*', 'Articulos.Principioactivo as Nombrearticulo', 'Prestadores.Nombre as Nombreprestador'])
        ->join('Detallearticulos', 'catalogos.Detallearticulo_id', 'Detallearticulos.id')
        ->join('Articulos', 'Detallearticulos.Articulo_id', 'Articulos.id')
        ->join('Prestadores', 'catalogos.Prestador_id', 'Prestadores.id')
        ->where('Detallearticulos.Estado_id', 3)
        ->get();
        return response()->json($catalogo, 200);
    }

    public function allPrestador(Prestadore $prestadore)
    {
        $catalogo = Catalogo::select(['Catalogos.*', 'Articulos.Principioactivo as Nombrearticulo', 'Prestadores.Nombre as Nombreprestador'])
            ->join('Detallearticulos', 'catalogos.Detallearticulo_id', 'Detallearticulos.id')
            ->join('Articulos', 'Detallearticulos.Articulo_id', 'Articulos.id')
            ->join('Prestadores', 'catalogos.Prestador_id', 'Prestadores.id')
            ->where('Detallearticulos.Estado_id', 3)
            ->where('catalogos.Prestador_id', $prestadore->id)
            ->get();
        return response()->json($catalogo, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Valor' => 'required|string'
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        $catalogo = Catalogo::create($input);
        return response()->json([
            'message' => 'Catalogo creado con exito!'
        ], 201);
    }

    public function update(Request $request, Catalogo $catalogo)
    {
        $catalogo->update($request->all());
        return response()->json([
            'message' => 'Catalogo actualizado con exito!'
        ]);
    }

    public function available(Request $request, catalogo $catalogo)
    {
        $catalogo->update([
            'Estado' => $request->Estado
        ]);
        return response()->json([
            'message' => 'Catalogo inhabilitado con exito!'
        ], 200);
    }
}
