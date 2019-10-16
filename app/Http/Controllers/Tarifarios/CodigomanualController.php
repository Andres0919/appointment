<?php

namespace App\Http\Controllers\Tarifarios;

use App\Modelos\Codigomanual;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Validator;

class CodigomanualController extends Controller
{
    public function all()
    {
        $codigomanual = Codigomanual::select(['codigomanuals.*','tm.Nombre as tipomanual','c.Codigo as cup'])
                                    ->join('tipomanuales as tm','codigomanuals.Tipomanual_id','tm.id')
                                    ->join('cups as c','codigomanuals.Cup_id','c.id')
                                    ->where('codigomanuals.Estado_id', 1)
                                    ->get();
        return response()->json($codigomanual,200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Codigo'  =>  'required|string|unique:Codigomanuals',
            'Descripcion'  =>  'required|string',
            'Valor'  =>  'required|string',
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        Codigomanual::create($input);
        return response()->json([
            'message'=> 'Codigomanual creado con Exito!'
        ],201);
    }

    public function update(Request $request, Codigomanual $codigomanual)
    {
        $codigomanual->update($request->all());
        return response()->json([
            'message' => 'Codigomanual actualizado con Exito!'
        ],200);
    }

    public function import(Request $request){
        $codigomanual = (new FastExcel)->import($request->data, function($line){
            return Codigomanual::create([
                'Tipomanual_id' => $line['Tipomanual_id'],
                'Cup_id' => $line['Cup_id'],
                'Codigo' => $line['Codigo'],
                'Descripcion' => $line['Descripcion'],
                'Valor' => $line['Valor']
            ]);
        });
        return response()->json([
            'message' => 'Codigomanual Cargado con exito!'
        ], 201);
    }

}
