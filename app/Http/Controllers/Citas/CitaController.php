<?php

namespace App\Http\Controllers\Citas;

use App\User;
use App\Modelos\Cita;
use App\Modelos\Agenda;
use App\Modelos\Estado;
use App\Modelos\Paciente;
use App\Modelos\Detallecita;
use App\Modelos\citapaciente;
use App\Modelos\Especialidade;
use App\Modelos\Especialidadtipoagenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CitaController extends Controller
{
    public function all(Request $request)
    {
        $citas = Cita::all();
        return response()->json($citas, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Hora_Inicio' => 'string',
            'Hora_Final' => 'string',
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        //return $request;
        $agenda = Agenda::find($request->agenda_id);
        $cita = new Cita;
        $cita->Hora_Inicio = $request->horainicio;
        $cita->Hora_Final = $request->horafinal;
        $agenda->cita()->save($cita);
        return response()->json([
            'message' => 'Cita Creada con Exito!'
        ], 201);
    }

    public function show(Cita $cita)
    {
        $cita = Cita::find($cita);
        if (!isset($cita)) {
            return response()->json([
                'message' => 'La Cita buscada no Existe!'], 404);
        }
        return response()->json($cita, 200);
    }

    public function update(Request $request, Cita $cita)
    {
         $cita->update($request->all());
        return response()->json([
            'message' => 'Cita Actualizada con Exito!'
        ], 200);
    }

    public function asignarcita(Request $request, Cita $cita){

        $agenda = Agenda::select(['c.*','agendas.Fecha as fecha','agendas.Especialidad_id as especilidad' ])
                ->join('consultorios as c','agendas.Consultorio_id','c.id')
                ->join('citas as ci','ci.Agenda_id','agendas.id')
                ->where('ci.id', $cita->id)
                ->where('ci.Estado_id', 3)
                ->first();

        if(isset($agenda)){
            if($agenda->Cantidad > $cita->Cantidad){
                $hora_inicio = $cita->Hora_Inicio;
                $hora_final = $cita->Hora_Final;
                $disponibildad = Paciente::join('cita_paciente as cp','cp.Paciente_id','pacientes.id')
                                        ->join('citas as c','cp.Cita_id','c.id')
                                        ->join('agendas as a','c.Agenda_id','a.id')
                                        ->where('a.Fecha', $agenda->fecha)
                                        ->where('pacientes.id',$request->Paciente_id)
                                        ->where(function ($query) use ($hora_inicio,$hora_final){
                                            $query->where('c.Hora_Inicio','>',$hora_inicio)
                                                ->where('c.Hora_Inicio','<',$hora_final);
                                        })
                                        ->orWhere(function ($query) use ($hora_inicio,$hora_final){
                                            $query->where('c.Hora_Final','>',$hora_inicio)
                                                ->where('c.Hora_Final','<',$hora_final);
                                        })
                                        ->first();

                $disponibildad2 = Paciente::join('cita_paciente as cp','cp.Paciente_id','pacientes.id')
                                        ->join('citas as c','cp.Cita_id','c.id')
                                        ->join('agendas as a','c.Agenda_id','a.id')
                                        ->where('a.Fecha', $agenda->fecha)
                                        ->where('pacientes.id',$request->Paciente_id)
                                        ->where('c.Hora_Inicio','=',$hora_inicio)
                                        ->first();
                if(isset($disponibildad) || isset($disponibildad2)){
                    return response()->json([
                        'message' => '¡El paciente tiene cita para ese día en se rango de hora!'
                    ], 422);
                }
                    
                $disponibildad3 = Paciente::join('cita_paciente as cp','cp.Paciente_id','pacientes.id')
                                    ->join('citas as c','cp.Cita_id','c.id')
                                    ->join('agendas as a','c.Agenda_id','a.id')
                                    ->where('pacientes.id',$request->Paciente_id)
                                    ->where('a.Especialidad_id',$agenda->especilidad)
                                    ->whereIn('cp.Estado_id',[4,7,11])
                                    ->first();

                if(isset($disponibildad3)){
                    return response()->json([
                        'message' => '¡El paciente ya tiene una cita del mismo tipo!'
                    ], 422);
                }

                $especialidades = Especialidade::select(['Especialidades.*'])
                                    ->join('especialidade_tipoagenda', 'Especialidades.id', 'especialidade_tipoagenda.Especialidad_id')
                                    ->where('especialidade_tipoagenda.id', $agenda->especilidad)
                                    ->first();
                
                if(isset($especialidades)){

                    $year = date('y');

                    $pacientes = Paciente::select(['pacientes.*'])
                                        ->join('cita_paciente as cp','pacientes.id','cp.id')
                                        ->where('cp.Paciente_id', $request->Paciente_id)
                                        ->where('cp.Cita_id', $cita->id)
                                        ->where('cp.Fecha_solicita', 'LIKE', $year.'%')
                                        ->where('cp.Estado_id', '<>', 6)
                                        ->first();

                    

                    $pivote = [
                        "Estado_id" => "4",
                        "Usuario_id" => auth()->id(),
                        "Fecha_solicita" => $request->fecha_solicitada
                    ];

            
                    $cita->paciente()->attach($request->Paciente_id,$pivote);
                    $cita->update([
                        'Cantidad' => $cita->Cantidad + 1,
                    ]);
                    
                    
                    $cita_paciente = Cita::select(['cp.*'])
                                    ->join('cita_paciente as cp','cp.Cita_id','citas.id')
                                    ->where('cp.Cita_id', $cita->id)
                                    ->where('cp.Paciente_id', $request->Paciente_id)
                                    ->first();
            
                    Detallecita::create([
                        "Citapaciente_id" => $cita_paciente->id,
                        "Usuario_id" => auth()->id(),
                        "Estado_id" => 4
                    ]);
                    if($agenda->Cantidad == $cita->Cantidad){
                        $cita->update([
                            'Estado_id' => 4
                        ]);
                    }
                }

            }else{
                return response()->json([
                    'message' => '¡La cita no tiene cupo!'
                ], 422);
            }

        }else{
            return response()->json([
                'message' => '¡No está disponible esta cita!'
            ], 422);
        }
        

        return response()->json([
            'message' => 'Se asignó la cita del paciente con Exito!'
        ], 200);
    }

    public function available(Request $request, Cita $cita){
        $cita->update($request->all());
       $pivote =[
                    'Actualizado_por' => auth()->id()
                ];
        $cita->estados()->attach($request->Estado, $pivote);

        if ($request->Estado == 4) {
            return response()->json([
                'message' => 'La cita esta Pendiente por confirmar'
            ],200);
        }elseif ($request->Estado == 6) {
            return response()->json([
               'message' => 'La cita fue Cancelada por el paciente'
            ],200);
        }elseif ($request->Estado == 8) {
            return response()->json([
                'message' => 'La cita esta en Curso'
            ],200);
        }elseif ($request->Estado == 9) {
           return response()->json([
               'message' => 'La cita fue Atendida con Exito'
           ],200);
       }elseif ($request->Estado == 10) {
           return response()->json([
               'message' => 'La cita fue Bloqueado con Exito'
           ],200);
       }elseif ($request->Estado == 11) {
           return response()->json([
               'message' => 'La cita fue Reasignado con Exito'
           ],200);
       }elseif ($request->Estado == 12) {
           return response()->json([
               'message' => 'La cita fue cancelada por Inasistencia con Exito'
           ],200);
       }
        return response()->json([
            'message' => 'Cita Actualizada con Exito!'
        ], 200);
    }

    public function enabled(){
        $citas = Cita::where('Estado', 3)->get();
        return response()->json($citas, 200);
    }

    public function cancelar(Cita $cita, Request $request){
        $cita->update([
            'Cantidad' => $cita->Cantidad - 1,
            'Estado_id' => 3
        ]);
        $cita_paciente = citapaciente::where('Cita_id', $cita->id)
                        ->where('Paciente_id', $request->Paciente_id)
                        ->first();

        $cita_paciente->update([
            'Estado_id' => 6
        ]);

        Detallecita::create([
            "Citapaciente_id" => $cita_paciente->id,
            "Usuario_id" => auth()->id(),
            "Motivo" => $request->motivo,
            "Estado_id" => 6
        ]);
        return response()->json([
            'message' => 'Se canceló la cita con Exito!',
        ], 200);
    }

    public function bloquearCita(Cita $cita){
        $estado = ($cita->Estado_id == 3)? 10 : 3; 
        $msg = ($cita->Estado_id == 3)? 'Cita Bloqueada' : 'Cita Desbloquiada'; 
        $cita->update(['Estado_id' => $estado]);
        
        return response()->json([
            'message' => $msg
        ], 200);
    }

    public function confirmar(Cita $cita, Request $request){
        $cita->update(["Estado_id" => 7]);

        $cita_paciente = citapaciente::where('Cita_id', $cita->id)
                            ->where('Paciente_id', $request->Paciente_id)
                            ->first();

        $cita_paciente->update([
            'Estado_id' => 7
        ]);

        Detallecita::create([
            "Citapaciente_id" => $cita_paciente->id,
            "Usuario_id" => auth()->id(),
            "Motivo" => $request->motivo,
            "Estado_id" => 7
        ]);
        return response()->json([
            'message' => 'Se confirmó la cita con Exito!'
        ], 200);
    }

    public function citaspendientesPaciente(Request $request){
       $citaspendientes = Cita::select(['citas.id as id','citas.Hora_Inicio','c.Nombre as Consultorio', 's.Nombre as Sede', 'u.name as Nombre_medico','u.apellido as Apellido_medico','e.Nombre as Especialidad','ta.name as Tipo_agenda','a.Fecha'])
                                ->join('cita_paciente as cp','cp.Cita_id','citas.id')
                                ->join('pacientes as p','cp.Paciente_id','p.id')
                                ->join('agendas as a','citas.Agenda_id','a.id')
                                ->join('especialidade_tipoagenda as et','a.Especialidad_id','et.id')
                                ->join('especialidades as e','et.Especialidad_id','e.id')
                                ->join('tipo_agendas as ta','et.Tipoagenda_id','ta.id')
                                ->join('consultorios as c','a.Consultorio_id','c.id')
                                ->join('sedes as s','c.Sede_id','s.id')
                                ->join('agendausers as au', 'au.Agenda_id', 'a.id')
                                ->join('users as u','au.Medico_id','u.id')
                                ->whereIn('cp.Estado_id', [4,7])
                                ->where('p.id',$request->Paciente_id)
                                ->get();
        return response()->json($citaspendientes,200);
    }

    public function cronogramaHoyMedico(){
        $citaspendientes = Cita::select(['citas.id as id','p.id as paciente_id', 'cp.id as cita_paciente_id','citas.Hora_Inicio', 'e.Nombre as Especialidad','ta.name as Tipo_agenda','a.Fecha','citas.Estado_id','p.Primer_Nom','p.SegundoNom','p.Primer_Ape','p.Segundo_Ape','p.Tipo_Doc','p.Num_Doc','p.Edad_Cumplida'])
                                 ->leftJoin('cita_paciente as cp','cp.Cita_id','citas.id')
                                 ->leftJoin('pacientes as p','cp.Paciente_id','p.id')
                                 ->join('agendas as a','citas.Agenda_id','a.id')
                                 ->join('especialidade_tipoagenda as et','a.Especialidad_id','et.id')
                                 ->join('especialidades as e','et.Especialidad_id','e.id')
                                 ->join('tipo_agendas as ta','et.Tipoagenda_id','ta.id')
                                 ->join('consultorios as c','a.Consultorio_id','c.id')
                                 ->join('sedes as s','c.Sede_id','s.id')
                                 ->join('agendausers as au', 'au.Agenda_id', 'a.id')
                                 ->join('users as u','au.Medico_id','u.id')
                                 ->whereIn('citas.Estado_id', [3,4,5,7])
                                 ->where('a.Fecha', date('Y-m-d'))
                                 ->where('u.id',auth()->id())
                                 ->get();
         return response()->json($citaspendientes,200);
    }

     //Inicio de Historia CLINICA listos y probados en POSMAN
    public function datospaciente(citapaciente $citapaciente){
        
         $datospaciente = citapaciente::select('Pacientes.*')
                                ->join('Pacientes', 'cita_paciente.Paciente_id', 'Pacientes.id')
                                // ->join('Pacienteantecedentes', 'cita_paciente.citapaciente_id', 'Pacienteantecedentes.citapaciente_id')
                                ->where('Pacientes.id',$citapaciente->Paciente_id)
                                ->first();
                                return response()->json($datospaciente, 200);
    }

    public function editarpaciente(Request $request, Paciente $paciente, citapaciente $citapaciente){
        if(!$this->isOpenCita($citapaciente->Estado_id)){
            return response()->json([
                'message' => '¡La historia del paciente no se encuentra activa!'
            ], 422);
        }

        $validate = Validator::make($request->all(),[
            'Edad_Cumplida' => 'required',
            'Etnia' => 'required',
            'Laboraen' => 'required',
            'Mpio_Labora' => 'required',
            'Direccion_Residencia' => 'required',
            'Mpio_Residencia' => 'required',
            'Telefono' => 'required',
            'Correo' => 'required',
            'Estrato' => 'required',
            'Celular' => 'required',
            'Num_Hijos' => 'required',
            'Vivecon' => 'required',
            'RH' => 'required',
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        // return $request->all();

        $paciente->update([
            'Edad_Cumplida' => $request->Edad_Cumplida,
            'Discapacidad' => $request->Discapacidad,
            'Grado_Discapacidad' => $request->Grado_Discapacidad,
            'Etnia' => $request->Etnia,
            'Laboraen' => $request->Laboraen,
            'Mpio_Labora' => $request->Mpio_Labora,
            'Direccion_Residencia' => $request->Direccion_Residencia,
            'Mpio_Residencia' => $request->Mpio_Residencia,
            'Telefono' => $request->Telefono,
            'Correo' => $request->Correo,
            'Estrato' => $request->Estrato,
            'Celular' => $request->Celular,
            'Num_Hijos' => $request->Num_Hijos,
            'Vivecon' => $request->Vivecon,
            'RH' => $request->RH,
        ]);
        return response()->json(['message' => 'Datos del paciente actualizados con exito!'], 201);
    }

    public function atender(Request $request, citapaciente $citapaciente ){
        $citapaciente->update(["Estado_id" => 8]);

        $Nompaciente = citapaciente::select('Pacientes.Primer_Nom')
            ->join('Pacientes', 'cita_paciente.Paciente_id', 'Pacientes.id')
            ->first();
        // return $citapaciente;
        return response()->json(['message' => 'Inicia consulta con el paciente'. ' ' . $Nompaciente->Primer_Nom], 200);
    }

    public function motivo(Request $request, citapaciente $citapaciente){
         
        if(!$this->isOpenCita($citapaciente->Estado_id)){
            return response()->json([
                'message' => '¡La historia del paciente no se encuentra activa!'
            ], 422);
        }

        $validate = Validator::make($request->all(),[
            'Motivoconsulta' => 'required|string|min:5',
            'Enfermedadactual' => 'required|string|min:20',
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }

         $citapaciente->update([
            'Tipocita_id' => $request->Tipocita_id,
            'Motivoconsulta' => $request->Motivoconsulta,
            'Enfermedadactual' => $request->Enfermedadactual,
            'Resultayudadiagnostica' => $request->Resultayudadiagnostica,
        ]);

        return response()->json(['message' => '!MC y EA guardado con exito!'], 201);
    }

    public function revisionsistema(Request $request, citapaciente $citapaciente){
        //  return $request->Oftalmologico;
        if(!$this->isOpenCita($citapaciente->Estado_id)){
            return response()->json([
                'message' => '¡La historia del paciente no se encuentra activa!'
            ], 422);
        }
        
        $idcitapaciente = citapaciente::select('id')
            ->where('id', $citapaciente->id)
            ->first();
        $idcitapaciente->update([
            'Oftalmologico' => $request->Oftalmologico,
            'Genitourinario' => $request->Genitourinario,
            'Otorrinoralingologico' => $request->Otorrinoralingologico,
            'Linfatico' => $request->Linfatico,
            'Osteomioarticular' => $request->Osteomioarticular,
            'Neurologico' => $request->Neurologico,
            'Cardiovascular' => $request->Cardiovascular,
            'Tegumentario' => $request->Tegumentario,
            'Respiratorio' => $request->Respiratorio,
            'Endocrinologico' => $request->Endocrinologico,
            'Gastrointestinal' => $request->Gastrointestinal,
            'Norefiere' => $request->Norefiere,
        ]);
        return response()->json([
            'message' => 'Anamnesis Almacenada con Exito!'
        ], 201);
    }

    public function anamnesis(citapaciente $citapaciente){

        $citapaciente = citapaciente::select('Motivoconsulta', 'Enfermedadactual', 'Resultayudadiagnostica', 'Oftalmologico',
                                                'Genitourinario','Otorrinoralingologico', 'Linfatico', 'Osteomioarticular', 'Neurologico',
                                                'Cardiovascular', 'Tegumentario', 'Respiratorio', 'Endocrinologico', 'Gastrointestinal', 'Norefiere'
                                            )
                                        ->where('id', $citapaciente->id)
                                        ->first();
        return response()->json($citapaciente, 200);
    }

    private function isOpenCita($estado){
        if ($estado == 8) {
            return true;
        }
        return false;
    }
}