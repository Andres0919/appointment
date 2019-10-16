<?php

namespace App\Http\Controllers\Tarifarios;

use App\Modelos\Codesumi;
use Illuminate\Http\Request;
use App\Modelos\Auditoria;
use App\Modelos\citapaciente;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Validator;

class CodesumiController extends Controller
{
    public function all()
    {
        $codesumi = Codesumi::select('codesumis.*','tipocodigos.Nombre as Nombredetallearticulo')
        ->join('tipocodigos','codesumis.Tipocodesumi_id','tipocodigos.id')
        ->get();

        return response()->json($codesumi, 200);
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
            'Lider de Sede',
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

    public function medicamentos(citapaciente $citapaciente){
        $rolesUser = auth()->user()->getRoleNames()->toArray();
        $niveles = $this->getNivelOrdenamiento($rolesUser);

        if(count($niveles) < 4){
            $niveles = [0,1,2,3];
        }
        
        $medicamentos = Codesumi::whereIn('Tipocodesumi_id',[1,2])
                                ->where(function ($query){
                                    $query->where('Nombre','<>','')
                                    ->whereNotNull('Nombre');
                                })
                                ->whereNotNull('Codigo')
                                ->whereNotNull('Frecuencia')
                                ->whereNotNull('Cantidadmaxordenar')
                                ->whereNotNull('Requiere_autorizacion')
                                ->whereNotNull('Nivel_Ordenamiento')
                                ->whereIn('Nivel_Ordenamiento', $niveles)
                                ->where('Estado_id', 1)
                                ->get();

        return response()->json($medicamentos, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Nombre' => 'required|string',
            'Codigo' => 'required|string|unique:Codesumis|unique:Cups',
        ]);
        
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }

        $codesumi = Codesumi::select('Codesumis.*')
                        ->where('Codesumis.Codigo', $request->Codigo)
                        ->first();
        if (isset($codesumi)) {
            return response()->json([
                'message' => 'Codesumi ya existe'
            ], 422);
        }

        $codesumi = Codesumi::create([
            'Nombre' => $request->Nombre,
            'Codigo' => $request->Codigo,
            'Frecuencia' => $request->Frecuencia, 
            'Cantidadmaxordenar' => $request->Cantidadmaxordenar,
            'Requiere_autorizacion' => $request->Requiere_autorizacion,
            'Nivel_Ordenamiento' => $request->Nivel_Ordenamiento,
            'Tipocodesumi_id' => $request->Tipocodesumi_id,
            'Estado_id' => 1
        ]);

        return response()->json([
            'message' => 'Codesumi creado con Exito!'
        ], 201);
    }

    public function show($Codesumi)
    {
        $codesumi = Codesumi::find($Codesumi);
        if (!isset($codesumi)) {
            return response()->json([
                'message' => 'El codigo buscado no existe verifica la consulta!'
            ], 404);
        }
        return response()->json($codesumi, 200);
    }

    public function update(Request $request, Codesumi $codesumi)
    {
        $msg = 'Actualizó';
        $cambio = false;
        if($request->Nombre != $codesumi->Nombre){
            $msg = $msg.' Nombre de "'.$codesumi->Nombre.'" a "'.$request->Nombre.'"';
            $cambio = true;
        }
        if($request->Codigo != $codesumi->Codigo){
            $msg = $msg.' Codigo de "'.$codesumi->Codigo.'" a "'.$request->Codigo.'"';
            $cambio = true;
        }
        if($request->Frecuencia != $codesumi->Frecuencia){
            $msg = $msg.' Frecuencia de "'.$codesumi->Frecuencia.'" a "'.$request->Frecuencia.'"';
            $cambio = true;
        }
        if($request->Cantidadmaxordenar != $codesumi->Cantidadmaxordenar){
            $msg = $msg.' Cantidadmaxordenar de "'.$codesumi->Cantidadmaxordenar.'" a "'.$request->Cantidadmaxordenar.'"';
            $cambio = true;            
        }
        if($request->Requiere_autorizacion != $codesumi->Requiere_autorizacion){
            $msg = $msg.' requiere auditoria de "'.$codesumi->Requiere_autorizacion.'" a "'.$request->Requiere_autorizacion.'"';
            $cambio = true;
        }
        if($request->Nivel_Ordenamiento != $codesumi->Nivel_Ordenamiento){
            $msg = $msg.' nivel de ordenamiento de "'.$codesumi->Nivel_Ordenamiento.'" a "'.$request->Nivel_Ordenamiento.'"';
            $cambio = true;            
        }

        if(!$cambio){
            return response()->json([
                'message' => 'codesumi actualizado con Exito!!'
            ], 200);
        }

        $codesumi->update([
            'Nombre' => $request->Nombre,
            'Codigo' => $request->Codigo,
            'Requiere_autorizacion' => $request->Requiere_autorizacion,
            'Nivel_Ordenamiento' => $request->Nivel_Ordenamiento,
            'Frecuencia' => $request->Frecuencia,
            'Cantidadmaxordenar' => $request->Cantidadmaxordenar,
        ]);
        
        Auditoria::create([
            'Descripcion' => $msg, 
            'Tabla' => 'Codesumis', 
            'Usuariomodifica_id' => auth()->user()->id,
            'Model_id' => $codesumi->id,
            'Motivo' => ''
        ]);
        

        return response()->json([
            'message' => 'codesumi actualizado con Exito!'
        ], 200);

    }

    public function available(Request $request, Codesumi $Codesumi)
    {
        $Codesumi->update([
          'Estado' => $request->Estado  
        ]);
        return response()->json([
            'message' => 'Estado de la Actualizada con Exito!'
        ], 200);
    }

    public function enabled(){
        $Codesumi = Codesumi::where('Estado', 1)->get();
        return response()->json($Codesumi, 200);
    }

    public function import(Request $request){
        $codesumi = (new FastExcel)->import($request->data, function($line){
            return Codesumi::create([
                'Nombre' => $line['Nombre'],
                'Codigo' => $line['Codigo'],
                'Estado' => $line['Estado']
            ]);
        });
        return response()->json([
            'message' => 'Carga de codigos sumimedical exitosa!'
        ], 200);
    }
}
