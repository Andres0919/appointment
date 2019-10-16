<?php

namespace App\Http\Controllers\Historia;


use App\Modelos\Pacienteantecedente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Paciente;
use App\User;
use App\Modelos\citapaciente;
use Illuminate\Support\Facades\Validator;

class PacienteanteceController extends Controller
{
    public function all()
    {
        return 'sdas';
    }

    public function store(Request $request, citapaciente $citapaciente)
    {
        if(!$this->isOpenCita($citapaciente->Estado_id)){
            return response()->json([
                'message' => '¡La historia del paciente no se encuentra activa!'
            ], 422);
        }
        $validate = Validator::make($request->all(),[
            'Descripcion' => 'string'
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
            
            foreach ($request->all() as $pa) {
                $citapaci = Pacienteantecedente::where('Pacienteantecedentes.citapaciente_id', $citapaciente->id)
                                            ->where('Pacienteantecedentes.Antecedente_id', $pa['id'])
                                            ->first();
                if (!isset($citapaci)) {
                     Pacienteantecedente::create([
                    'Antecedente_id' => $pa['id'],
                    'Citapaciente_id' => $citapaciente->id,
                    'Descripcion' => $pa['Descripcion'],
                    'Usuario_id' => auth()->user()->id,
                ]);
                }else {
                    $citapaci->update([
                        'Descripcion' => $pa['Descripcion'],
                    ]);
                }           
        }
        return response()->json([
            'message' => 'Antecedentes del paciente creado con exito!'
        ],201);
    }
    

    public function antecedentes(citapaciente $citapaciente){

        $pacienteantecedente = Pacienteantecedente::select('a.id','a.Nombre', 'pacienteantecedentes.Descripcion','a.created_at','a.updated_at')
                                        ->join('antecedentes as a','pacienteantecedentes.Antecedente_id','a.id')
                                        ->where('pacienteantecedentes.citapaciente_id', $citapaciente->id)
                                        ->get();
        return response()->json($pacienteantecedente, 200);
    }

    
    private function isOpenCita($estado){
        if ($estado == 8) {
            return true;
        }
        return false;
    }
}
