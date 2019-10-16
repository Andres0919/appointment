<?php

namespace App\Http\Controllers\Tarifarios;

use App\Modelos\Cupservicio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CupservicioController extends Controller
{
    public function all()
    {
        $cupservicios = Cupservicio::select(['Cupservicios.*','Cups.Codigo as cup','Tiposervicios.Nombre as tiposervicio'])
                                ->join('Cups','Cupservicios.Cup_id','Cups.id')
                                ->join('Tiposervicios','Cupservicios.Tiposervicio_id','Tiposervicios.id')
                                ->get();

        return response()->json($cupservicios, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Cup_id'  =>  'required',
            'Tiposervicio_id'  =>  'required',
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        Cupservicio::create($input);
        return response()->json([
            'message'=> 'Cupservicio creado con Exito!'
        ],201);
    }

    public function update(Request $request, Cupservicio $cupservicio)
    {
        $cupservicio->update($request->all());
        return response()->json([
            'message' => 'Cupservicio actualizado con Exito!'
        ],200);
    }
}
