<?php

namespace App\Http\Controllers\Agendas;

use App\Modelos\Cargo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class CargoController extends Controller
{

    public function all()
    {
        $cargos = Cargo::where('Estado_id', 1)->get();

        return response()->json($cargos, 200);
    }
    
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'Nombre' => 'required|string|unique:Cargos'
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($validate, 422);
        }

        $input = $request->all();
        $cargo = Cargo::create($input);
        return response()->json([
            'message' => 'Cargo creado con exito!'
        ], 201);
    }

    
    public function update(Request $request, Cargo $cargo)
    {
        $cargo->update($request->all());
        return response()->json([
            'message' => 'Cargo actualizado con exito!'
        ], 200);
    }
}
