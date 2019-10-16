<?php

namespace App\Http\Controllers\Sedeprestadores;

use App\Modelos\Prestadore;
use App\Modelos\Municipio;
use App\Modelos\Serviciosede;
use App\Modelos\Sedeproveedore;
use App\Modelos\Historialservicio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SedeproveedorController extends Controller
{
    public function all(Request $request)
    {
        $sedeproveedor = Sedeproveedore::select(['Sedeproveedores.*', 'Municipios.Nombre as Municipio', 'Prestadores.Nombre as Nombreprestador'])
                                        ->join('Municipios', 'Sedeproveedores.Municipio_id', 'Municipios.id')
                                        ->join('Prestadores', 'Sedeproveedores.Prestador_id', 'Prestadores.id')
                                        ->where('Sedeproveedores.Estado_id', 1)
                                        ->where('Prestadores.id', $request->Prestador_id)
                                        ->get();
        return response()->json($sedeproveedor, 200);
    }

    public function allproveedores(){
        $sedeproveedor = Sedeproveedore::select(['Sedeproveedores.*'])
                                        ->join('Prestadores', 'Sedeproveedores.Prestador_id', 'Prestadores.id')
                                        ->where('Sedeproveedores.Estado_id', 1)
                                        ->where('Prestadores.Tipoprestador_id', 2)
                                        ->where('Prestadores.Estado_id', 1)
                                        ->get();
        return response()->json($sedeproveedor, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Codigo_habilitacion' => 'required|string|unique:Sedeproveedores',
            'Nombre' => 'required|string',
            'Nivelatencion' => 'required|string',
            'Correo1' => 'required|string',
            'Telefono1' => 'required|string',
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        $sedeproveedor = Sedeproveedore::create($input);
        
        return response()->json([
            'message' => 'Sede del prestador creada con exito!'
        ], 201);
    }
    public function storeServiciosede(Request $request){
        $validate = Validator::make($request->all(), [
            'Servicio_id' => 'required|string',
            'Sede_id' => 'required|string',
            'Tarifa' => 'required|string',
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }

        $serviciosede = new Serviciosede;
        $serviciosede->Sede_id = $request->Sede_id;
        $serviciosede->Servicio_id = $request->Servicio_id;
        $serviciosede->Tarifa = $request->Tarifa;
        $serviciosede->save();

        $historialservicio = new Historialservicio;
        $historialservicio->Serviciosede_id = $serviciosede->id;
        $historialservicio->Tarifa = $serviciosede->Tarifa;
        $historialservicio->save();
        
        return response()->json([
            'message' => 'Servicio sede creado con exito!'
        ]);


    }

    public function getSedeId(Request $request){
        $sedeproveedor = Sedeproveedore::select(['Sedeproveedores.*'])
                                        ->where('Sedeproveedores.Estado_id', 1)
                                        ->where('Prestadores.id', $request->Prestador_id)
                                        ->get();
        return response()->json($sedeproveedor, 200);
    }

    public function update(Request $request, Sedeproveedore $sedeproveedore)
    {
        $sedeproveedore->update($request->all());
        return response()->json([
            'message' => 'La sede del proveedor fue actualizada con exito!'
        ], 200);
    }

    public function disable(Sedeproveedore $sedeproveedore){
        $sedeproveedore->update([
            'Estado_id' => 2 
        ]);
        return response()->json([
            'message' => '¡Sede deshabilitada con exito!'
        ], 200);
    }
}
