<?php

namespace App\Http\Controllers\Contratos;

use App\Modelos\Contrato;
use App\Modelos\Valorsoat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ContratoController extends Controller
{
    public function all()
    {
        $contrato = Contrato::all();
        return response()->json($contrato, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Tarifa' => 'required|string',
            'Fecha_inicio' => 'required|string',
            'Fecha_final' => 'required|string',
        ]);
        if ($validate->fails()) {
            return response()->json(['errores' =>$validate->errors()], 422);
        }
        $contrato = new Contrato();
        $contrato->Soat_id = $request->Soat_id;
        $contrato->Iss2000_id = $request->Iss2000_id;
        $contrato->Iss2001_id = $request->Iss2001_id;
        $contrato->Cup_id = $request->Cup_id;
        $contrato->Propio_id = $request->Propio_id;
        $contrato->Tcontrato_id = $request->Tcontrato_id;
        $contrato->Prestador_id = $request->Prestador_id;
        $contrato->Fecha_inicio = $request->Fecha_inicio;
        $contrato->Fecha_final = $request->Fecha_final;
        $contrato->Tarifa = $request->Tarifa;

        $contrato->save();
        return response()->json([
            'message' => 'Contrato creado con Exito!'
        ]);

    }


    public function update(Request $request, Contrato $contrato)
    {
        //
    }
}
