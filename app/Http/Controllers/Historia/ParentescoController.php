<?php

namespace App\Http\Controllers\Historia;

use App\Modelos\Parentesco;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ParentescoController extends Controller
{
    public function all()
    {
        $parentesco = parentesco::all();  
        return response()->json($parentesco, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Nombre' => 'string'
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        $parentesco = parentesco::create($input);
        return response()->json([
            'message' => 'Parentesco creado con exito!'
        ],201);
    }

    public function update(Request $request, Parentesco $parentesco)
    {
        $parentesco->update($request->all());
        return response()->json([
            'message' => 'Parentesco actualizado con exito!'
        ], 200);
    }
}
