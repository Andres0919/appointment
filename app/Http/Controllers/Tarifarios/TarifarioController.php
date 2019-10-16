<?php

namespace App\Http\Controllers\Tarifarios;

use App\Modelos\Tarifario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TarifarioController extends Controller
{
    public function all()
    {
        $tarifario = Tarifario::select(['Tarifarios.*', 'Tiposervicios.Nombre as nombreAmbito', 'Sedeproveedores.Nombre as nombreSede'])
        ->join('Cupservicios', 'Tarifarios.Cupservicio_id', 'Cupservicios.id')
        ->join('Tiposervicios', 'Cupservicios.Tiposervicio_id', 'Tiposervicios.id')
        ->join('Contratos', 'Tarifarios.Contrato_id', 'Contratos.id')
        ->join('Sedeproveedores', 'Contratos.Sedeproveedore_id', 'Sedeproveedores.id')
        ->where('Tarifarios.Estado_id', 1)
        ->get();
        return response()->json($tarifario, 200);
    }
    
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Fechainicio'  =>  'required|string',
            'Fechafinal'  =>  'required|string',
            'Tarifa'  =>  'required|string',
            'Valor'  =>  'required|string',
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        Tarifario::create($input);
        return response()->json([
            'message'=> 'Tarifario creado con Exito!'
        ],201);
    }

    public function update(Request $request, Tarifario $tarifario)
    {
        $tarifario->update($request->all());
        return response()->json([
            'message' => 'Tarifario actualizado con Exito!'
        ],200);
    }
}
