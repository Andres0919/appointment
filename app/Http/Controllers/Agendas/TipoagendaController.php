<?php

namespace App\Http\Controllers\Agendas;

use App\Modelos\TipoAgenda;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TipoagendaController extends Controller
{
    //Fines administractivos
    public function all()
    {
        $tipoagenda = TipoAgenda::all();
        return response()->json($tipoagenda, 200);
    }

    public function enables()
    {
        $tipoagenda = TipoAgenda::where('Estado_id', 1)->get();
        return response()->json($tipoagenda, 200);
    }

    public function store(Request $request)
    {
        $result = Validator::make($request->all(),[
            'name'        => 'required|string|unique:tipo_agendas',
        ]);
        if ($result->fails()) {
            $errores = $result->errors();
            return response()->json($result, 422);
        }
        $input = $request->all();
        $tipoagenda = TipoAgenda::create($input);
        return response()->json([
            'message' => 'Tipo de Agenda Creada con Exito!'
        ], 201);

    }

    public function show(TipoAgenda $tipoAgenda)
    {
        return response()->json($tipoAgenda, 200);
    }

    public function update(Request $request, TipoAgenda $tipoAgenda)
    {
        $tipoAgenda->update($request->all());
        return response()->json([
            'message' => 'Tipo de Agenda Actualizado con Exito!'
        ], 200);
    }

    public function available(Request $request, TipoAgenda $tipoAgenda)
    {
        $tipoAgenda->update($request->all());
        return response()->json([
            'message' => 'Estado de Tipo Agenda Actualizado con Exito!'
        ], 200);
    }

    //Uso solo para agendamiento
    public function habilitados(){
        $tipoAgenda = TipoAgenda::where('estado_id', 3)->get();
        return response()->json($tipoAgenda, 200);
    }


}
