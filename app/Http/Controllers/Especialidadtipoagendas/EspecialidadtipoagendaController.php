<?php

namespace App\Http\Controllers\Especialidadtipoagendas;

use App\Modelos\Especialidade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Especialidadtipoagenda;
use Illuminate\Support\Facades\Validator;

class EspecialidadtipoagendaController extends Controller
{
    
    public function all()
    {
        $especialidadtipoagenda = Especialidadtipoagenda::select(['especialidade_tipoagenda.*', 'Especialidades.Nombre as nombreEspecilidad', 'tipo_agendas.name as nombreActividad' ])
                                                        ->join('Especialidades', 'especialidade_tipoagenda.Especialidad_id', 'Especialidades.id')
                                                        ->join('tipo_agendas', 'especialidade_tipoagenda.Tipoagenda_id', 'tipo_agendas.id')
                                                        ->where('Especialidades.Estado_id', 1)
                                                        ->where('tipo_agendas.Estado_id', 1)
                                                        ->get();
        return response()->json($especialidadtipoagenda, 200);
    }

    public function store(Request $request, Especialidade $especialidade)
    {
       
        $validate = Validator::make($request->all(),[
            'Duracion' => 'required',
        ]);
        
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $especialidadtipoagenda = new Especialidadtipoagenda();
        $especialidadtipoagenda->Tipoagenda_id = $request->Tipoagenda_id;
        $especialidadtipoagenda->Especialidad_id = $especialidade->id;
        $especialidadtipoagenda->Duracion = $request->Duracion;
        $especialidadtipoagenda->save();
        return response()->json([
            'message' => 'Se guardo con Exito!'
        ], 200);
    }

    
    public function update(Request $request, Especialidadtipoagenda $especialidadtipoagenda)
    {
        //
    }
                                                                                                                               
    public function destroy(Especialidadtipoagenda $especialidadtipoagenda)
    {
        //
    }
}
