<?php

namespace App\Http\Controllers\Historia;

use App\Modelos\Conducta;
use Illuminate\Http\Request;
use App\Modelos\citapaciente;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ConductaController extends Controller
{

    public function all()
    {
        $conducta = Conducta::all();
        return response()->json($conducta, 200);
    }

    public function fin(Request $request, citapaciente $citapaciente)
    {
        // return $request->all();
        if(!$this->isOpenCita($citapaciente->Estado_id)){
            return response()->json([
                'message' => '¡La historia del paciente no se encuentra activa!'
            ], 422);
        }

        $validate = Validator::make($request->all(),[
            'Planmanejo' => 'required|string|min:5',
            'Recomendaciones' => 'required|string|min:5',
            'Destinopaciente' => 'required|string|min:5',
        ]);       
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $conduc = Conducta::where('Conductas.citapaciente_id', $citapaciente->id)
                                            ->first();
        // $citapacienteid = citapaciente::where('id', $citapaciente->id)->first();
        if (!isset($conduc)) {
            Conducta::create([
                'Citapaciente_id' => $citapaciente->id,
                'Planmanejo' => $request->Planmanejo,
                'Recomendaciones' => $request->Recomendaciones,
                'Destinopaciente' => $request->Destinopaciente,
                'Finalidad' => $request->Finalidad,
            ]);
            return response()->json(['message' => 'La consulta finaliza exitosamente!'], 201);
       }else {
           $conduc->update([
            'Planmanejo' => $request->Planmanejo,
            'Recomendaciones' => $request->Recomendaciones,
            'Destinopaciente' => $request->Destinopaciente,
            'Finalidad' => $request->Finalidad,
           ]);
           return response()->json(['message' => 'Conducta actualizada exitosamente!'], 201);
       }
    }

    public function getConductaByCita(Request $request){
        $conduc = Conducta::where('Conductas.citapaciente_id', $request->cita_paciente_id)
                    ->first();
        return response()->json([
                'conducta' => $conduc,
            ], 201);
    }

    private function isOpenCita($estado){
        if ($estado == 8) {
            return true;
        }
        return false;
     }
    
}
