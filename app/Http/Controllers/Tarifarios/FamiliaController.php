<?php

namespace App\Http\Controllers\Tarifarios;

use App\Modelos\Cup;
use App\Modelos\Familia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FamiliaController extends Controller
{
   
    public function all()
    {
        $familia = Familia::select(['Familias.*', 'Tipofamilias.Nombre as Nombretipofamilia'])
        ->join('Tipofamilias', 'Familias.Tipofamilia_id', 'Tipofamilias.id')
        ->where('Familias.Estado_id', 1)
        ->get();
        return response()->json($familia, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'Nombre' => 'required|string|unique:familias',
            'Responsable' => 'required|string|'
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        $familia = Familia::create($input);
        // $cup = Cup::find($request->Cup_id);
        // $familia->cups()->save($cup);
        return response()->json([
            'message' => 'Familia creada con exito!'
        ], 201);
    }
    public function update(Request $request, Familia $familia)
    {
        $familia->update($request->all());
        return response()->json([
            'message' => 'Familia actualizada con exito!'
        ], 201);
    }

    
    public function  unidadfuncional(){
        $familias = Familia::select(['familias.*'])
                            ->join('tipofamilias as tf','familias.Tipofamilia_id','tf.id')
                            ->where('tf.id',4)
                            ->get();
        return response()->json($familias, 200);
    }

}
