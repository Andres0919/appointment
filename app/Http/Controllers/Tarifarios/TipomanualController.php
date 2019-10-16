<?php

namespace App\Http\Controllers\Tarifarios;

use App\Modelos\Tipomanuale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TipomanualController extends Controller
{
    public function all()
    {
        $tipomanuales = Tipomanuale::where('Estado_id', 1)->get();

        return response()->json($tipomanuales,200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Nombre'  =>  'required|string',
            'Descripcion'  =>  'required|string',
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        Tipomanuale::create($input);
        return response()->json([
            'message'=> 'Tipomanual creado con Exito!'
        ],201);
    }

    public function update(Request $request, Tipomanuale $tipomanuale)
    {
        $tipomanuale->update($request->all());
        return response()->json([
            'message' => 'Tipomanuale actualizado con Exito!'
        ],200);
    }

    public function available(Request $request, Tipomanuale $tipomanuale)
    {
        $tipomanuale->update([
            'Estado_id' => $request->Estado_id
        ]);
        return response()->json([
            'message' => 'Estado del Tipomanuale actualizado con Exito!'
        ], 200);
    }

}
