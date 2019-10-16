<?php

namespace App\Http\Controllers\Cups;

use App\Modelos\Cup;
use App\Modelos\Familia;
use App\Modelos\Auditoria;
use App\Modelos\citapaciente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Validator;

class CupController extends Controller
{
    public function all()
    {
        $cups = Cup::all();
        return response()->json($cups, 200);
    }

    public function update(Cup $cup, Request $request){
        $msg = 'Actualizó';
        $cambio = false;
        if($request->Requiere_auditoria != $cup->Requiere_auditoria){
            $msg = $msg.' requiere auditoria de "'.$cup->Requiere_auditoria.'" a "'.$request->Requiere_auditoria.'"';
            $cambio = true;
        }
        if($request->Nivelordenamiento != $cup->Nivelordenamiento){
            $msg = $msg.' nivel de ordenamiento de "'.$cup->Nivelordenamiento.'" a "'.$request->Nivelordenamiento.'"';
            $cambio = true;            
        }

        if(!$cambio){
            return ;
        }

        $cup->update([
            'Requiere_auditoria' => $request->Requiere_auditoria,
            'Nivelordenamiento' => $request->Nivelordenamiento,
        ]);
        
        Auditoria::create([
            'Descripcion' => $msg, 
            'Tabla' => 'Cups', 
            'Usuariomodifica_id' => auth()->user()->id,
            'Model_id' => $cup->id,
            'Motivo' => ''
        ]);
        

        return response()->json([], 200);
    }

    private function getNivelOrdenamiento($rolesUser){

        $nivel0 = [
            'Auxiliar de Enfermeria',
            'Auxiliar Sede Tipo D',
            'Nutricion',
            'Psicologia',
            'Fisioterapia',
            'Optometria',
            'Terapia Respiratoria',
            'Fonoaudiologia',
            'Neuropsicologia',
            'Trabajo Social',
            'Linea de frente',
        ];
        $nivel1 = [
            'Medicina General', 
            'Medicina Alternativa',
            'Odontologia',
            'Enfermeria',
            'Medicina Laboral'
        ];
        $nivel2 = [
            'Medico Experto RCCVM',
            'Medico Experto Salud Mental',
            'Medico Experto Reumatologia',
            'Medico Experto Anticoagulados',
            'Medico Experto Nefroproteccion',
            'Medico Experto Respiratorios',
            'Medico Experto Trasmisibles Cronicas',
            'Psiquiatria',
            'Ginecologia',
            'Obstetricia',
            'Medicina Interna',
            'Otorrinolaringologia',
            'Oftalmologia',
            'Ortopedia y Traumatologia',
            'Cirugia General',
            'Pediatria',
            'Dermatologia',
            'Medicina del Deporte',
            'Toxicologia',
            'Fisiatria',
            'Urologia',
            'Especialidades de Odontologia',
            'Lider de Sede'
        ];
        $nivel3 = [
            'Neurologia',
            'Cardiologia',
            'Anestesiologia',
            'Medicina Familiar',
            'Hematologia',
            'Nefrologia',
            'Endocrinologia',
            'Cirugia Coloproctologica',
            'Alergologia',
            'Mastologia',
            'Neumologia',
            'Medicina del Dolor',
            'Oncologia',
            'Neurocirugia',
            'Infectologia',
            'Reumatologia',
            'Electrofisiologia',
            'Gestion de Solicitudes',
            'Gestion de Solicitudes Odontologia'
        ];
        $nivel4 = [
            'Tutelas',
            'Coordinador Gestión de Solicitudes'
        ];

        foreach ($nivel4 as $nivel) {
            if(in_array($nivel,$rolesUser)){
                return [0,1,2,3,4];
            }
        }

        foreach ($nivel3 as $nivel) {
            if(in_array($nivel,$rolesUser)){
                return [0,1,2,3];
            }
        }
        foreach ($nivel2 as $nivel) {
            if(in_array($nivel,$rolesUser)){
                return [0,1,2];
            }
        }
        foreach ($nivel1 as $nivel) {
            if(in_array($nivel,$rolesUser)){
                return [0,1];
            }
        }
        foreach ($nivel0 as $nivel) {
            if(in_array($nivel,$rolesUser)){
                return [0];
            }
        }

        return [];
    }

    public function cupsOrden(Request $request,citapaciente $citapaciente)
    {
        
        $rolesUser = auth()->user()->getRoleNames()->toArray();
        $niveles = $this->getNivelOrdenamiento($rolesUser);

        if(count($niveles) < 4){
            $niveles = [0,1,2,3];
        }
        $cups = Cup::select('cups.*')
                        ->join('cupfamilias as cf','cf.Cup_id','cups.id')
                        ->join('familias as f','cf.Familia_id','f.id')
                        ->where('f.id','<>',115)
                        ->where('f.Tipofamilia_id',3)
                        ->whereIn('cups.Nivelordenamiento',$niveles)
                        ->get();

        return response()->json($cups, 200);
    }

    public function cupsOrdenInterconsulta(citapaciente $citapaciente){
        $rolesUser = auth()->user()->getRoleNames()->toArray();
        if($citapaciente->Tipocita_id != 1){
            $niveles = $this->getNivelOrdenamiento($rolesUser);
        }else{
            $niveles = [0,1,2,3];
        }

        $cups = Cup::select('cups.*')
                        ->join('cupfamilias as cf','cf.Cup_id','cups.id')
                        ->join('familias as f','cf.Familia_id','f.id')
                        ->where('f.id',115)
                        ->where('f.Tipofamilia_id',3)
                        ->whereIn('cups.Nivelordenamiento',$niveles)
                        ->get();

        return response()->json($cups, 200);
    }

    public function serviciosOrden()
    {
        $servicios = Familia::where('Tipofamilia_id', 3)->get();

        return response()->json($servicios, 200);
    }

    public function cupsCapitulo(Request $request){
        $familias = [];
        foreach ($request->Familia_id as $familia) {
            array_push($familias, $familia['id']);
        }

        $cups = Cup::select(['cups.*','cf.Familia_id'])
                        ->join('cupfamilias as cf','cf.Cup_id','cups.id')
                        ->whereIn('cf.Familia_id', $familias)
                        ->get();

        return response()->json($cups, 200);

    }
    // public function store(Request $request)
    // {
    //     $validate = Validator::make($request->all(),[
    //         'Codigo' => 'required|string|unique:Cups'
    //     ]);
    //     if ($validate->fails()) {
    //         $errores = $validate->errors();
    //         return response()->json($errores, 422);
    //     }
    //     $input = $request->all();
    //     $cup = Cup::create($input);
    //     return response()->json([
    //         'message' => 'Cups creado con exito!'
    //     ], 201);
    // }

    // public function import(Request $request){
    //     $cups = (new FastExcel)->import($request->data, function($line){
    //         return Cup::create([
    //             'Codigo' => $line['Codigo'],
    //             'Nombre' => $line['Nombre'],
    //             'Genero' => $line['Genero'],
    //             'Edad_Inicial' => $line['Edad_Inicial'],
    //             'Edad_Final' => $line['Edad_Final'],
    //             'Archivo' => $line['Archivo'],
    //             'Qx' => $line['Qx'],
    //             'Dx_Requerido' => $line['Dx_Requerido']
    //         ]);
    //     });
    //     return response()->json([
    //         'message' => 'Carga de codigos cups exito!'
    //     ], 200);
    // }
}
