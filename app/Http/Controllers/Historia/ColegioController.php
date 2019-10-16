<?php

namespace App\Http\Controllers\Historia;

use App\Modelos\Colegio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Municipio;
use Illuminate\Support\Facades\Validator;

class ColegioController extends Controller
{
    public function all()
    {
        $colegio = Colegio::select('Colegios.id', 'Colegios.Nombre as NomColegio','Colegios.Codigodanecolegio as CodeDane', 'Municipios.Nombre as NomMunicipio')
        ->join('Municipios', 'Colegios.Municipio_id', 'Municipios.id')
        ->where('Colegios.Estado_id', 1)
        ->get();

        return response()->json($colegio, 200);
    }

    
    public function store(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(),[
            'Nombre'            => 'required|string|unique:Colegios',
            'Codigodanecolegio' => 'required|string'
        ]);
        if ($validator->fails()) {
            $errores = $validator->errors();
            return response()->json($errores, 422);
        }
        Colegio::create([
            'Nombre' => $request->Nombre,
            'Codigodanecolegio' => $request->Codigodanecolegio,
            'Municipio_id' => $request->Municipio_id,
        ]);
        return response()->json([
            'message' => 'Colegio creado con exito!'
        ], 201);
    }

    
    public function disable(Request $request, Colegio $colegio)
    {
        $colegio->update([
            'Estado_id' => 2
        ]);
        return response()->json([
            'message' => 'Colegio deshabilitado con exito'
        ], 201);
    }

    public function getColegioByName(Request $request)
    {
        $colegio = Colegio::select('Colegios.id', 'Colegios.Nombre as NomColegio','Colegios.Codigodanecolegio as CodeDane', 'Municipios.Nombre as NomMunicipio')
            ->join('Municipios', 'Colegios.Municipio_id', 'Municipios.id')
            ->where('Colegios.Estado_id', 1)
            ->where('Colegios.Nombre', 'LIKE', '%'.$request->nombre.'%')
            ->get();

        // if (isset($colegio)) {
        //     return response()->json([
        //         'message' => 'Colegio not found'
        //     ], 404);
        // }

        return response()->json($colegio, 200);
    }

}
