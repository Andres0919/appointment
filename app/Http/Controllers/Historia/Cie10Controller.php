<?php

namespace App\Http\Controllers\Historia;

use App\Modelos\Cie10;
use App\Modelos\Marca;
use Illuminate\Http\Request;
use App\Modelos\citapaciente;
use App\Modelos\Cie10paciente;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class Cie10Controller extends Controller
{
    public function all()
    {
        $cie10 = Cie10::all();
        return response()->json($cie10, 200);
    }

    public function store(Request $request, citapaciente $citapaciente)
    {
        foreach ($request->all() as $cie10s) {
            Cie10paciente::create([
                'Cie10_id' => $cie10s['Cie10_id'],
                'Citapaciente_id' => $citapaciente->id,
                'Esprimario' => $cie10s['Esprimario'],
                'Tipodiagnostico' => $cie10s['Tipodiagnostico']
            ]);
            if ($cie10s['Tipodiagnostico'] != 'Impresión diagnóstica') {
                foreach ($cie10s['Marcapaciente'] as $marca) {
                    Marca::create([
                    'Citapaciente_id' => $citapaciente->id,
                    'Marca' => $marca,
                    // 'Nivel' => $request->Nivel
                ]);
                }
            }
        }
        return response()->json([
                    'message' => 'cie10s creado con exito!'
            ], 201);
    }

    public function update(Request $request, Marca $marca)
    {
        $marca->update([
            'Estado_id' => $request->Estado_id
        ]);
    }

    public function setDiagnostic(Request $request, citapaciente $citapaciente) {

        $cie10 = Cie10paciente::create([
                'Cie10_id' => $request->Cie10_id,
                'Citapaciente_id' => $citapaciente->id,
                'Esprimario' => true
            ]);

        return response()->json([
            'message' => 'cie10s creado con exito!'
        ], 201);

    }

    public function getDiagnostico(citapaciente $citapaciente) {

        $cie10 = Cie10paciente::select(
            'cie10pacientes.id', 
            'cie10pacientes.Cie10_id', 
            'cie10pacientes.Esprimario',
            'cie10pacientes.Tipodiagnostico',
            'cie10s.Descripcion as Nombre',
            'cie10s.Codigo_CIE10 as Codigo')
            ->join('cie10s', 'cie10s.id', 'cie10pacientes.Cie10_id')
            
            ->where('cie10pacientes.Citapaciente_id', $citapaciente->id)
            ->get();

        return response()->json([
            'cie10' => $cie10,
        ], 201);
    }

    public function deleteDiagnostico(Cie10paciente $cie10paciente) {

        $cie10paciente->delete();

        return response()->json([
            'message' => 'Diagnostic delete successfully'
        ], 201);

    }
}
