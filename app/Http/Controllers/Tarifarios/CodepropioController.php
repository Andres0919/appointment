<?php

namespace App\Http\Controllers\Tarifarios;

use App\Modelos\Codesumi;
use App\Modelos\Codepropio;
use App\Modelos\Prestadore;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Modelos\Sedeproveedore;

class CodepropioController extends Controller
{
    public function all(Request $request)
    {
        $codepropio = Codepropio::select(['Codepropios.*', 'Codesumis.Nombre as Nombrecodesumi', 'sp.Nombre as Nombreprestador'])
            ->join('Codesumis', 'Codepropios.Codesumi_id', 'Codesumis.id')
            ->join('sedeproveedores as sp', 'Codepropios.sedeproveedor_id', 'sp.id')
            ->where('Codepropios.Estado_id', 1)
            ->where('Codepropios.sedeproveedor_id', $request->Prestador_id)
            ->get();
        return response()->json($codepropio, 200);
    }

    public function store(Request $request, Sedeproveedore $sedeproveedore)
    {
        // return $request->all();
        $validate = Validator::make($request->all(),[
            'Descripcion' => 'required|string',
            'Valor' => 'required',
        ]);
        $codepropio = Codepropio::select('Codepropios.*')
                        ->where('Codepropios.Codigo', $request->Codigo)
                        ->where('Codepropios.sedeproveedor_id', $request->sedeproveedor_id)
                        ->first();
        if (isset($codepropio)) {
            return response()->json([
                'message' => 'Ya existe este codigo para este prestador'
            ], 422);
        }
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }

        $input = $request->all();
        $codepropio = Codepropio::create($input);
        return response()->json([
            'message' => 'Codepropio se guardo con Exito!'
        ], 200);

    }

    public function update(Request $request, Codepropio $codepropio)
    {
        $codepropio->update($request->all());
        return response()->json([
            'message' => 'Codepropio actualizado con Exito!'
        ],200);
    }

    public function enabled(){
        $codepropio = Codepropio::where('Estado', 1)->get();
        return response()->json($codepropio, 200);
    }
}
