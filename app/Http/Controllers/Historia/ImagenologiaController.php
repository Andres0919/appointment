<?php

namespace App\Http\Controllers\Historia;

use App\Modelos\Imagenologia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\citapaciente;

class ImagenologiaController extends Controller
{
    private function isOpenCita($estado)
    {
        if ($estado == 8) {
            return true;
        }
        return false;
    }

    public function imagenologia(citapaciente $citapaciente)
    {
        if (!$this->isOpenCita($citapaciente->Estado_id)) {
            return response()->json([
                'message' => '¡La historia del paciente no se encuentra activa!'
            ], 422);
        }
        $imagenologia = Imagenologia::select(
            'Indicacion',
            'Hallazgos',
            'Conclusion'
        )
        ->where('Citapaciente_id', $citapaciente->id)
        ->first();

        return response()->json($imagenologia, 200);
    }

    public function store(Request $request, citapaciente $citapaciente)
    {
        if (!$this->isOpencita($citapaciente->Estado_id)) {
            return response()->json([
                'message' => '¡La historia del paciente no se encuentra activa!'
            ], 422);
        }
        // $citapacienteid = citapaciente::select('id')
        //     ->where('id', $citapaciente->id)
        //     ->first();
        $imagenologia = Imagenologia::where('Imagenologias.citapaciente_id', $citapaciente->id)
            ->first();
        if (!isset($imagenologia)) {
            Imagenologia::create([
                // 'Citapaciente_id' => $citapacienteid->id,
                'Citapaciente_id' => $citapaciente->id,
                'Indicacion' => $request->Indicacion,
                'Hallazgos' => $request->Hallazgos,
                'Conclusion' => $request->Conclusion,
            ]);
            return response()->json([
                'message' => 'Historia creada con exito'
            ]);
        }else {
            $imagenologia->update([
                'Indicacion' => $request->Indicacion,
                'Hallazgos' => $request->Hallazgos,
                'Conclusion' => $request->Conclusion,
            ]);
            return response()->json([
                'message' => 'Historia actualizada con exito'
            ]);
        }
    }


}
