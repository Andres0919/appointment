<?php

namespace App\Http\Controllers\Transaciones;

use Illuminate\Http\Request;
use App\Modelos\Tipotransacion;
use App\Http\Controllers\Controller;
use App\Modelos\Transacion;
use Illuminate\Support\Facades\Validator;


class TipotransacionController extends Controller
{
    
    public function all()
    {
        $tipotransacion = Tipotransacion::select(['Tipotransacions.*', 'Tipos.Nombre as TipoNombre', 'Transacions.Nombre as TransacionNombre'])
        ->join('Tipos', 'Tipotransacions.Tipo_id', 'Tipos.id')
        ->join('Transacions', 'Tipotransacions.Transacion_id', 'Transacions.id')
        ->where('Transacions.Estado_id', 1)
        ->get();
        return response()->json($tipotransacion, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Transacion_id' => 'required',
            'Tipo_id' => 'required'
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        $tipotransacion = Tipotransacion::create($input);
        return response()->json([
            'message' => 'tipotransacion creado con exito!'
        ], 201);
    }

    public function update(Request $request, Tipotransacion $tipotransacion)
    {
        $tipotransacion->update($request->all());
        return response()->json([
            'message' => 'Tipotransacion actualizado con exito!'
        ]);
    }
}
