<?php

namespace App\Http\Controllers\Agendas;

use App\Modelos\Actividadcargo;
use App\Modelos\Cargo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class ActividadcargoController extends Controller
{
    public function all(Cargo $cargo)
    {
        $actividadcargo = Actividadcargo::where('Estado_id', 1)->where('Cargo_id', $cargo->id)->get();

        return response()->json($actividadcargo, 200);
    }

    public function store(Request $request, Cargo $cargo)
    {
        $validate = Validator::make($request->all(), [
            'Nombre' => 'required|string|unique:Actividadcargos'
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($validate, 422);
        }
        $actividadcargo = new Actividadcargo;
        $actividadcargo->Nombre = $request->Nombre;

        $cargo->actividadcargo()->save($actividadcargo);
        return response()->json([
            'message' => 'Actividadcargo creada con exito!'
        ], 201);
    }

    public function update(Request $request,Cargo $cargo, Actividadcargo $actividadcargo)
    {
        $actividadcargo->update($request->all());
        return response()->json([
            'message' => 'Actividadcargo actualizado con exito!'
        ], 200);
    }
}
