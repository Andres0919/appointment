<?php

namespace App\Http\Controllers\Agendas;

use App\User;
use App\Modelos\Cita;
use App\Modelos\Sede;
use App\Modelos\Especialidade;
use App\Modelos\Agenda;
use App\Modelos\citapaciente;
use App\Modelos\Consultorio;
use App\Modelos\Tipoagenda;
use App\Modelos\agendauser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AgendaController extends Controller
{
    public function all($fecha)
    {
        $agenda = Agenda::all()
            ->whereHas("permissions", function($q){ $q->where("name", "agenda");})
            ->get();
        return response()->json($agenda, 200 );
    }

    public function agendaEspecialidad(){
        $especialidades = Especialidade::select(['et.id as et_id','especialidades.*','ta.name','c.Sede_id as sede'])
                                        ->join('especialidade_tipoagenda as et','et.Especialidad_id','especialidades.id')
                                        ->join('tipo_agendas as ta','et.Tipoagenda_id','ta.id')
                                        ->join('agendas as a','a.Especialidad_id','et.id')
                                        ->join('consultorios as c','a.Consultorio_id','c.id')
                                        ->where('especialidades.Estado_id',1)
                                        ->where('ta.Estado_id',1)
                                        ->where('a.Fecha', '>=' , date('Y-m-d'))
                                        ->distinct()
                                        ->get();
        return response()->json($especialidades, 200);
    }

    public function agendaSede(Request $request){
        $sedes = Sede::select(['sedes.*'])
                        ->join('consultorios as c','c.Sede_id','sedes.id')
                        ->join('agendas as a','a.Consultorio_id','c.id')
                        ->join('especialidade_tipoagenda as et','a.Especialidad_id','et.id')
                        ->where('sedes.Estado_id',1)
                        ->where('et.Especialidad_id',$request->especialidad)
                        ->where('a.Fecha', '>=' , date('Y-m-d'))
                        ->distinct()
                        ->get();

        return response()->json($sedes, 200);
    }

    public function agendaDisponible(Request $request){
        $agendas = Agenda::select(['agendas.id', 's.id as Sede', 'a.Nombre as nombreConsultorio', 'c.Nombre as Especialidad', 'd.name as tipoActividad', 'u.name as nombreMedico', 'u.apellido as apellidoMedico', 
                                    'agendas.fecha', 'agendas.Hora_Inicio', 'agendas.Hora_Final'])
                        ->join('consultorios as a','agendas.Consultorio_id','a.id')
                        ->join('sedes as s','a.Sede_id','s.id')
                        ->join('especialidade_tipoagenda as b','agendas.Especialidad_id','b.id')
                        ->join('especialidades as c', 'b.Especialidad_id', 'c.id')
                        ->join('tipo_agendas as d', 'b.Tipoagenda_id', 'd.id')
                        ->join('agendausers as au', 'au.Agenda_id', 'agendas.id')
                        ->join('users as u','au.Medico_id','u.id')
                        ->with(['citas' => function($query) { 
                            $query->select('id','Agenda_id','Hora_Inicio','Estado_id')
                            ->where('Estado_id', 3);
                        }])
                        ->where('agendas.Fecha', '>=' , date('Y-m-d'))
                        ->whereHas('citas',function ($query){
                            $query->where('Estado_id', 3);
                        }) 
                        ->where('agendas.Estado_id',3) 
                        ->where('s.id',$request->sede)
                        ->where('b.id',$request->tipo_agenda)
                        ->get();
        return response()->json($agendas, 200);
    }

    public function agendamedicos(Request $request){
        $agendas = Agenda::select(['agendas.id', 'agendas.Hora_Inicio', 'agendas.Hora_Final','sedes.Nombre as Sede','consultorios.Nombre as consultorio','d.name as tAgenda','users.name as medico','agendas.Fecha','agendas.Estado_id','b.Duracion'])
                        ->join('consultorios','agendas.Consultorio_id','consultorios.id')
                        ->join('sedes','consultorios.Sede_id','sedes.id')
                        ->join('especialidade_tipoagenda as b','agendas.Especialidad_id','b.id')
                        ->join('especialidades as c', 'b.Especialidad_id', 'c.id')
                        ->join('tipo_agendas as d', 'b.Tipoagenda_id', 'd.id')
                        ->join('agendausers as au', 'au.Agenda_id', 'agendas.id')
                        ->join('users','au.Medico_id','users.id')
                        ->with(['citas' => function($query) { 
                            $query->select('citas.id','citas.Agenda_id','citas.Hora_Inicio','citas.Estado_id','p.Primer_Nom','p.SegundoNom','p.Primer_Ape','p.Segundo_Ape','p.Tipo_Doc','p.Num_Doc','cp.Estado_id as estado_citapaciente')
                                    ->leftJoin('cita_paciente as cp','cp.Cita_id','citas.id')
                                    ->leftJoin('pacientes as p','cp.Paciente_id','p.id')
                                    ->whereIn('citas.Estado_id',[3,4,7,8,9,10,12]);
                        }])
                        ->where('au.Medico_id',$request->medico_id)
                        ->whereIn('agendas.Estado_id',[3,10])
                        ->get();
        return response()->json($agendas, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'fechas' => 'required',
        ]); 
        
        if ($validate->fails())
        {
            $errores = $validate->errors(); 
            return response()->json($errores, 422); 			          
        }
        
        forEach($request->fechas as $fecha){
            $hora_inicio = $fecha.' '.$request->hora_inicio;
            $hora_final = $fecha.' '.$request->hora_final;
            $agenda = Agenda::where('Consultorio_id',$request->consultorio_id)
                                ->where('Fecha', $fecha)
                                ->whereIn('Estado_id', [3,10])
                                ->where(function ($query) use ($hora_inicio,$hora_final){
                                    
                                    $query->where(function ($query) use ($hora_inicio,$hora_final){
                                        $query->where('Hora_Inicio','>',$hora_inicio)
                                            ->where('Hora_Inicio','<',$hora_final);
                                    })
                                    ->orWhere(function ($query) use ($hora_inicio,$hora_final){
                                        $query->where('Hora_Final','>',$hora_inicio)
                                                ->where('Hora_Final','<',$hora_final);
                                    });
                                })
                                ->first();
            $agendaDentroRango = Agenda::where('Consultorio_id',$request->consultorio_id)
                            ->where('Fecha', $fecha)
                            ->whereIn('Estado_id', [3,10])
                            ->where('Hora_Inicio','<=',$hora_inicio)
                            ->where('Hora_Final','>=',$hora_final)
                            ->first();
            $agendaocupada = Agenda::where('Consultorio_id',$request->consultorio_id)
                                ->where('Fecha', $fecha)
                                ->whereIn('Estado_id', [3,10])
                                ->where('Hora_Inicio',$hora_inicio)
                                ->where('Hora_Final',$hora_final)
                                ->first();
            if(isset($agenda) || isset($agendaocupada) || isset($agendaDentroRango)){
                return response()->json([
                    'message' => $agenda], 422);
            }
            $medico = Agenda::join('agendausers as au','au.Agenda_id','agendas.id')
                                ->join('users as u','au.Medico_id','u.id')
                                ->where('agendas.Fecha',$fecha)
                                ->whereIn('agendas.Estado_id', [3,10])
                                ->where('u.id', $request->medico_id)
                                ->where('u.estado_user', 1)       
                                ->where(function ($query) use ($hora_inicio,$hora_final){
                                    
                                    $query->where(function ($query) use ($hora_inicio,$hora_final){
                                        $query->where('agendas.Hora_Inicio','>',$hora_inicio)
                                            ->where('agendas.Hora_Inicio','<',$hora_final);
                                    })
                                    ->orWhere(function ($query) use ($hora_inicio,$hora_final){
                                        $query->where('agendas.Hora_Final','>',$hora_inicio)
                                            ->where('agendas.Hora_Final','<',$hora_final);
                                    });
                                })
                                ->first();
            $medicoNodisponble = Agenda::join('agendausers as au','au.Agenda_id','agendas.id')
                                ->join('users as u','au.Medico_id','u.id')
                                ->where('agendas.Fecha',$fecha)
                                ->whereIn('agendas.Estado_id', [3,10])
                                ->where('u.id', $request->medico_id)
                                ->where('u.estado_user', 1)
                                ->where('agendas.Hora_Inicio','<',$hora_final)
                                ->where('agendas.Hora_Final','>',$hora_inicio)
                                ->first();

            $agendaMedicoOcupada = Agenda::join('agendausers as au','au.Agenda_id','agendas.id')
                                ->join('users as u','au.Medico_id','u.id')
                                ->where('agendas.Fecha',$fecha)
                                ->whereIn('agendas.Estado_id', [3,10])
                                ->where('u.id', $request->medico_id)
                                ->where('u.estado_user', 1)
                                ->where('agendas.Hora_Inicio',$hora_final)
                                ->where('agendas.Hora_Final',$hora_inicio)
                                ->first();                   
            if(isset($medico) || isset($medicoNodisponble) || isset($agendaMedicoOcupada)){
                return response()->json([
                    'message' => '¡Médico ocupado!'], 422);
            }
        }


        $usuario = $request->user();
        //return response()->json(count($request->citas), 422); 
        forEach($request->fechas as $fecha){
            $agenda = Agenda::create([
                'Usuariocrea_id' => $usuario->id,
                'Especialidad_id' => $request->especialidad_id['id'],
                'Consultorio_id' => $request->consultorio_id,
                'Fecha' => $fecha,
                //'Medico_id' => $request->medico_id,
                'Hora_Inicio' => $fecha.' '.$request->hora_inicio,
                'Hora_Final' => $fecha.' '.$request->hora_final,
            ]);
            agendauser::create([
                'Medico_id' => $request->medico_id,
                'Agenda_id' => $agenda->id
            ]);
            forEach($request->citas as $cita){
                if($fecha == $cita['date']){
                    Cita::create([
                        'Agenda_id' => $agenda->id,
                        'Hora_Inicio' => $fecha.' '.$cita['time'],
                        'Hora_Final' =>  $fecha.' '.$cita['horaFin'],
                        'Estado_id' => ($cita['estado']) ? 3 : 10,//3 disponible, 10 bloqueada
                    ]);
                }
            }
        }
            

        return response()->json([
            'message' => '¡Agenda creado con Exito!'], 201);
    }

    public function show(Agenda $agenda)
    {
        $agenda = Agenda::find($agenda);
        if (!isset($agenda)) {
            return response()->json([
                'message' => 'El Agenda buscado no Existe!'], 404);
        }
        return response()->json($agenda, 200);
    }

    public function update(Request $request, Agenda $agenda)
    {
        $agenda->update($request->all());
        return response()->json([
            'message' => 'Agenda Actualizada con Exito!'
        ], 200);
    }

    public function available(Request $request, Agenda $agenda)
    {
        $agenda->update($request->all());
        return response()->json([
            'message' => 'Estado del Agenda Actualizada con Exito!'
        ], 200);
    }

    public function inhabilitarAgenda(Agenda $agenda){
        $agenda->update([
            'Estado_id' => 6
        ]);

        return response()->json([
            'message' => 'Estado de la Agenda Actualizada con Exito!'
        ], 200);
    }

    public function enabled(){
        $agenda = Agenda::where('Estado', 3);
        return response()->json($agenda, 200);
    }

    public function cancelarAgenda(Agenda $agenda){
        $agenda->update(['Estado_id' => 6]);

        Cita::where('Agenda_id', $agenda->id)
          ->update(['Estado_id' => 6]);

        $citas = Cita::where('Agenda_id', $agenda->id)->get();
        foreach ($citas as $cita) {
            
            citapaciente::where('Cita_id', $cita['id'])
                        ->update(['Estado_id' => 6]);
        }

        return response()->json([
            'message' => 'Agenda cancelada!',
        ], 200);
    }

    public function bloquearAgenda(Agenda $agenda){
        $estado = ($agenda->Estado_id == 3)? 10 : 3; 
        $msg = ($agenda->Estado_id == 3)? 'Agenda Bloqueada' : 'Agenda Desbloqueada'; 
        $agenda->update(['Estado_id' => $estado]);

        
        return response()->json([
            'message' => $msg
        ], 200);
    }

}
