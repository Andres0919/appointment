<?php

namespace App\Http\Controllers\Consultorios;

use App\Modelos\Consultorio;
use App\Modelos\Sede;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ConsultorioController extends Controller
{
    public function all($sede)
    {
        $consultorios = Consultorio::where('Sede_id',$sede)->get();

        return response()->json($consultorios, 200);
    }

    public function store(Request $request,Sede $sede)
    {
        $validate = Validator::make($request->all(),[
            'Nombre' => 'required|string|max:50',
            'Descripcion' => 'string|max:100',
            'Cantidad' => 'string|max:2',
        ]);
        $consultorio = Consultorio::select('Consultorios.*')
                        ->where('Consultorios.Sede_id', $sede->id)
                        ->where('Consultorios.Nombre', $request->Nombre)
                        ->first();
        if (isset($consultorio)) {
            return response()->json([
                'message' => 'Consultorio ya existe en la sede'
            ], 422);
        }
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        
        //return($request);
        $consultorio = new Consultorio;
        $consultorio->Nombre = $request->Nombre;
        $consultorio->Descripcion = $request->Descripcion;
        $consultorio->Cantidad = $request->Cantidad;

        $sede->consultorio()->save($consultorio);
        
        return response()->json([
            'message' => 'Consultorio Creado con Exito!'
        ], 201);
    }

    public function show(Consultorio $consultorio)
    {
        $consultorio = Consultorio::find($consultorio);
        if (!isset($consultorio)) {
            return response()->json([
                'message' => 'El Consultorio buscado no Existe!'], 404);
        }
        return response()->json($consultorio, 200);
    }

    public function update(Request $request, Sede $sede, Consultorio $consultorio)
    {
        $consultorio->Nombre = $request->Nombre;
        $consultorio->Descripcion = $request->Descripcion;
        $consultorio->Cantidad = $request->Cantidad;

        $sede->consultorio()->save($consultorio);

        return response()->json([
            'message' => 'Consultorio Actualizado con Exito!'
        ], 200);
    }

    public function available(Request $request, Consultorio $consultorio)
    {
        $consultorio->update($request->all());
        return response()->json([
            'message' => 'Consultorio Actualizado con Exito!'
        ], 200);
    }

    public function enable(){
        $consultorios = Consultorio::where('Estado', 1);
        return response()->json($consultorio, 200);
    }
}
