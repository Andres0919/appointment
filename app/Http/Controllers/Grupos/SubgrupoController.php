<?php

namespace App\Http\Controllers\Grupos;

use App\Modelos\Grupo;
use App\Modelos\Subgrupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class SubgrupoController extends Controller
{
    public function all(Request $request)
    {
        $subgrupo = Subgrupo::select(['Subgrupos.*', 'Grupos.Nombre as NombreGrupo'])
        ->join('Grupos', 'Subgrupos.Grupo_id', 'Grupos.id')
        ->where('Subgrupos.Estado_id', 1)
        ->where('Grupos.id',$request->Grupo_id)
        ->get();
        return response()->json($subgrupo, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Nombre' => 'required|string|unique:subgrupos'
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        $subgrupo = Subgrupo::create($input);
        return response()->json([
            'message' => 'Subgrupo creada con exito!'
        ], 201);
    }

    public function update(Request $request, Subgrupo $subgrupo)
    {
        $subgrupo->update($request->all());
        return response()->json([
            'message' => 'Subgrupo actualizado con exito!'
        ], 200);
    }

    public function available(Request $request, Subgrupo $subgrupo)
    {
        $subgrupo->update([
            'Estado' => $request->Estado
        ]);
        return response()->json([
            'message' => 'Subgrupo inhabilitado con exito!'
        ], 200);
    }

    public function enabled()
    {
        $subgrupo = Subgrupo::select(['Subgrupos.*', 'Grupos.Nombre as NombreGrupo'])
        ->join('Grupos', 'Subgrupos.Grupo_id', 'Grupos.id')
        ->where('Subgrupos.Estado_id', 1)
        ->get();
        return response()->json($subgrupo, 200);
    }
}