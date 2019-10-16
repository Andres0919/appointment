<?php

namespace App\Http\Controllers\Tarifarios;

use App\Modelos\Tipofamilia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TipofamiliaController extends Controller
{
    public function all()
    {
        $tipofamilia = Tipofamilia::where('Estado_id', 1)->get();
        return response()->json($tipofamilia, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'Nombre' => 'required|string|unique:tipofamilias'
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        $tipofamilia = Tipofamilia::create($input);
        return response()->json([
            'message' => 'Tipofamilia creada con exito!'
        ]);
    }

   
    public function update(Request $request, Tipofamilia $tipofamilia)
    {
        $tipofamilia->update($request->all());
        return response()->json([
            'message' => 'Tipofamilia actualizada con Exito!'
        ],200);
    }

}
