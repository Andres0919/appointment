<?php

namespace App\Http\Controllers\Files;

use Storage;

use App\Modelos\citapaciente;
use App\Modelos\Paciente;
use App\Modelos\Files;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
    public function setFiles(Request $request, citapaciente $citapaciente)
    {
        $pacientes = Paciente::select(['pacientes.*'])
                        ->where('id', $citapaciente->Paciente_id)
                        ->first();

        if (isset($pacientes)) {
            if ($files = $request->file('files')) {
                foreach ($files as $file) {
                    $name = $file->getClientOriginalName();
                    $extension = pathinfo($name, PATHINFO_EXTENSION);
                    $guid = $pacientes->Num_Doc.'DT'.date("Y-m-d H:i:s.u").'.'.$extension;
                    $pathdb = '/storage/pacientes/'.$pacientes->Num_Doc.'/transcripcion/'.$guid;
                    $path = '../storage/app/public/pacientes/'.$pacientes->Num_Doc.'/transcripcion/';
                    if ($file->move(public_path($path), $guid)) {
                        $files = Files::create([
                            'Name' => $name,
                            'Path' => $pathdb,
                            'CitaPaciente_id' => $citapaciente->id
                        ]);
                    }
                }

                return response()->json([
                    'message' => 'Archivos guardados de manera exitosa'
                ], 200);
            }
        } else {
            return response()->json([
                'message' => 'Paciente no encontrado'
            ], 404);
        }
    }

    public function getFiles(citapaciente $citapaciente)
    {
        $files = Files::select('Files.*')
                    ->join('cita_paciente', 'Files.CitaPaciente_id', 'cita_paciente.id')
                    ->join('Pacientes', 'cita_paciente.Paciente_id', 'Pacientes.id')
                    ->where('Pacientes.id', $citapaciente->Paciente_id)
                    ->get();

        if (isset($files)) {
            return response()->json($files, 201);
        } 

        return response()->json([
            'message' => 'Archivo no encontrado'
        ], 404);

    }
}
