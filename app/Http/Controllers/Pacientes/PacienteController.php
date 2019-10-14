<?php

namespace App\Http\Controllers\Pacientes;

use App\User;
use App\Modelos\Cita;
use App\Modelos\Estado;
use App\Modelos\Paciente;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PacienteController extends Controller
{

    public function all()
    {
        $paciente = Paciente::all();
        return response()->json($paciente, 200);
    }

    public function citaPendiente(Paciente $paciente){
        $citapendiente = Cita::where('paciente_id', $paciente->id)->first();
        return response()->json($citapendiente, 200);
    }

    public function store(Request $request)
    {
        
        $validate = Validator::make($request->all(),[
            'Num_Doc' => 'required|string|unique:pacientes',
            'Primer_Nom' => 'required|string',
            'Primer_Ape' => 'required|string',
            'Edad_Cumplida' => 'integer',
            'Estado_Afiliado' => 'integer',
        ]); 
        if ($validate->fails())
        {
            $errores = $validate->errors(); 
            return response()->json($errores, 422); 			          
        }
            $input = $request->all();
            $paciente = Paciente::create($input);

        return response()->json([
            'message' => 'Paciente creado con Exito!'], 201);
    }

    public function show($paciente)
    {
        $paciente = Paciente::find($paciente);
        if (!isset($paciente)) {
            return response()->json([
                'message' => 'El Paciente buscado no Existe!'], 404);
        }
        return response()->json($paciente, 200);
    }

    public function showEnabled($cedula)
    {
        $paciente = Paciente::where('Num_Doc', $cedula)->first();
        if (!isset($paciente)) {
            return response()->json([
                'message' => 'El paciente consultado no existe en nuestra base de datos validar en HOSVITAL si cambio de UT'
            ]);
            // Estado 2 el paciente tiene derecho a garantia en salud
        }elseif ($paciente->Estado_Afiliado == 2) {
            return response()->json([
                'message' => 'El paciente Se encuentra retirado de Sumimedical'
            ], 200);
            //Estado 3 el paciente tiene derecho a garantia en salud
        }elseif ($paciente->Estado_Afiliado == 3) {
            return response()->json([
                'message' => 'El paciente se encuentra en Proteccion Laboral Cotizante'
            ], 200);
        }elseif ($paciente->Estado_Afiliado == 4) {
            return response()->json([
                'message' => 'El paciente se encuentra en Proteccion Laboral  Beneficiario'
            ], 200);
        }
        return response()->json([
            'paciente' => $paciente
        ], 200);
    }

    public function update(Request $request, Paciente $paciente)
    {
        $paciente->update($request->all());
        return response()->json([
            'message' => 'Paciente Actualizado con Exito!'
        ], 200);
    }

    public function updateUbicacionData(Request $request, Paciente $paciente){
        $paciente->update([
            'Telefono' => $request->Telefono,
            'Celular1' => $request->Celular1,
            'Celular2' => $request->Celular2,
            'Correo1' => $request->Correo1,
            'Correo2' => $request->Correo2
        ]);
        return response()->json([
            'message' => 'Datos de ubicacion del paciente actualizados'
        ], 200);
    }

    public function getPaciente($cedula){
        //return($request->cedula);
        $paciente = Paciente::where("Num_Doc", $cedula)->first();
        if (!isset($paciente)) {
            return response()->json([
                'Message' => 'Paciente No existe en el sistema'
            ], 404);
        }
        return response()->json($paciente, 200);
    }

    // public function import(Request $request){
    //     $paciente = (new FastExcel)->import($request->data, function($line){
    //         return Paciente::create([
    //             'Region' => $line['Region'],
    //             'UT' => $line['UT'],
    //             'Primer_Nom' => $line['Primer_Nom'],
    //             'SegundoNom' => $line['SegundoNom'],
    //             'Primer_Ape' => $line['Primer_Ape'],
    //             'Segundo_Ape' => $line['Segundo_Ape'],
    //             'Tipo_Doc' => $line['Tipo_Doc'],
    //             'Num_Doc' => $line['Num_Doc'],
    //             'Sexobiologico' => $line['Sexobiologico'],
    //             'Sexoidentifica' => $line['Sexoidentifica'],
    //             'Fecha_Afiliado' => $line['Fecha_Afiliado'],
    //             'Fecha_Naci' => $line['Fecha_Naci'],
    //             'Edad_Cumplida' => $line['Edad_Cumplida'],
    //             'Discapacidad' => $line['Discapacidad'],
    //             'Grado_Discapacidad' => $line['Grado_Discapacidad'],
    //             'Tipo_Afiliado' => $line['Tipo_Afiliado'],
    //             'Parentesco' => $line['Parentesco'],
    //             'TipoDoc_Cotizante' => $line['TipoDoc_Cotizante'],
    //             'Doc_Cotizante' => $line['Doc_Cotizante'],
    //             'Tipo_Cotizante' => $line['Tipo_Cotizante'],
    //             'Estado_Afiliado' => $line['Estado_Afiliado'],
    //             'Dane_Mpio' => $line['Dane_Mpio'],
    //             'Mpio_Afiliado' => $line['Mpio_Afiliado'],
    //             'Dane_Dpto' => $line['Dane_Dpto'],
    //             'Departamento' => $line['Departamento'],
    //             'Subregion' => $line['Subregion'],
    //             'Dpto_Atencion' => $line['Dpto_Atencion'],
    //             'Mpio_Atencion' => $line['Mpio_Atencion'],
    //             'IPS' => $line['IPS'],
    //             'Sede_Odontologica' => $line['Sede_Odontologica'],
    //             'Telefono' => $line['Telefono'],
    //             'Celular1' => $line['Celular1'],
    //             'Celular2' => $line['Celular2'],
    //             'Correo1' => $line['Correo1'],
    //             'Correo2' => $line['Correo2'],
    //             'Nacionalidad' => $line['Nacionalidad'],
    //             'Direccion' => $line['Direccion'],
    //             'Niveleducativo' => $line['Niveleducativo'],
    //             'Estadocivil' => $line['Estadocivil'],
    //             'Tipozona' => $line['Tipozona'],
    //             'Estrato' => $line['Estrato'],
    //             'Nivelsisben' => $line['Nivelsisben'],
    //             'Numhijos' => $line['Numhijos'],
    //             'Vivecon' => $line['Vivecon'],
    //             'Ocupacion' => $line['Ocupacion'],
    //             'Etnia' => $line['Etnia'],
    //             'Religion' => $line['Religion'],
    //             'RH' => $line['RH']
    //         ]);
    //     });
    // }
}
