<?php

namespace App\Http\Controllers\Especialidades;

use App\User;
use Illuminate\Http\Request;
use App\Modelos\Especialidade;
use App\Modelos\TipoAgenda;
use App\Modelos\Especialidadtipoagenda;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EspecialidadeController extends Controller
{
    public function all()
    {
        $especialidad = Especialidade::where('Estado_id', 1)->get();
        return response()->json($especialidad, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Nombre' => 'required|string|unique:Especialidades',
            'Descripcion' => 'string|Max:100'
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        $especialidad = Especialidade::create($input);
        return response()->json([
            'message' => 'Especialidad creada con exito!'
        ]);
    }

    public function update(Request $request, Especialidade $especialidade)
    {
        $especialidade->update($request->all());
        return response()->json([
            'message' => 'Especialidad actualizada con exito!'
        ], 200);
    }

    public function available(Request $request, Especialidade $especialidade)
    {
        $especialidade->update([
            'Estado' => $request->Estado
        ]);
        return response()->json([
            'message' => 'Estado de la Especialidad Actualizada con Exito!'
        ], 200);
    }

    public function especialidadMedico(User $user){
        $role = $user->getRoleNames();
        $especialidadMedico = Especialidade::whereIn('Nombre',$role)->get();
        return response()->json($especialidadMedico,200);
    }
    
    public function especialidadActividad(Especialidade $especialidade){
        $tipoactividad = Especialidadtipoagenda::where('especialidade_tipoagenda.Especialidad_id', $especialidade->id)
        ->select(['especialidade_tipoagenda.id', 'Especialidades.Nombre as nombreEspecialidad', 'tipo_agendas.name as nombreActividad', 'especialidade_tipoagenda.Duracion'])
        ->join('tipo_agendas', 'especialidade_tipoagenda.Tipoagenda_id', 'tipo_agendas.id')
        ->join('Especialidades', 'especialidade_tipoagenda.Especialidad_id', 'Especialidades.id')
        ->where('Especialidades.Estado_id', 1)
        ->where('tipo_agendas.Estado_id', 1)
        ->get();
        return response()->json($tipoactividad, 200);

    }
}
