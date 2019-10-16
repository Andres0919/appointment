<?php

namespace App\Http\Controllers\Tarifarios;

use App\Modelos\Prestadore;
use App\Modelos\Contrato;
use App\Modelos\Menucipio;
use App\Modelos\Valorsoat;
use Illuminate\Http\Request;
use Intervention\Image\Response;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PrestadorController extends Controller
{

    public function all()
    {
        $prestador = Prestadore::where('Estado_id', 1)->get();
        return response()->json($prestador);
    }

    public function prestadoresmedicamentos()
    {
        $prestador = Prestadore::where('Estado_id', 1)
                                ->where('Tipoprestador_id', 2)
                                ->get();
        return response()->json($prestador);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Nombre'  =>  'required|string',
            'Nit'  =>  'required|string|unique:prestadores',
            'Direccion'  =>  'required|string',
            'Correo1'  =>  'required|string',
            'Telefono1'  =>  'required|string',
            'Codigo_prestador'  =>  'required|string',
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        Prestadore::create($input);
        return response()->json([
            'message'=> 'Prestador creado con Exito!'
        ],201);
    }

    public function show(Prestadore $prestadore)
    {
        $prestador = Prestadore::find($prestadore);
        if (!isset($prestador)) {
            return response()->json([
                'message' => 'Elprestador buscado no existe verifica la consulta'
            ], 404);
        }
        return response()->json($prestador, 200);
    }

    public function update(Request $request, Prestadore $prestadore)
    {
        $prestadore->update($request->all());
        return response()->json([
            'message' => 'Prestador actualizado con Exito!'
        ],200);
    }

    public function available(Request $request, Prestadore $prestadore)
    {
        $prestadore->update([
            'Estado' => $request->Estado
        ]);
        return response()->json([
            'message' => 'Estado del prestador actualizado con Exito!'
        ], 200);
    }

    public function disable(Prestadore $prestadore){
        $prestadore->update([
            'Estado_id' => 2 
        ]);
        return response()->json([
            'message' => '¡Prestador deshabilitado con exito!'
        ], 200);
    }

    public function import(Request $request){
        $prestadore = (new FastExcel)->import($request->data, function($line){
            return Prestadore::create([
                'Nombre' => $line['Nombre'],
                'Nit' => $line['Nit'],
                'Direccion' => $line['Direccion'],
                'Correo1' => $line['Correo1'],
                'Correo2' => $line['Correo2'],
                'Telefono1' => $line['Telefono1'],
                'Telefono2' => $line['Telefono2'],
                'Municipio_id' => $line['Municipio_id'],
                'Codigo_habilitacion' => $line['Codigo_habilitacion']
            ]);
        });
        return response()->json([
            'message' => 'Carga de prestadores exitosa!'
        ], 200);
    }

   
}