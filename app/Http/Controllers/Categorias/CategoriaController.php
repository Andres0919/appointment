<?php

namespace App\Http\Controllers\Categorias;

use App\Modelos\Categoria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{

    public function all()
    {
        $categorias = Categoria::where('Estado_id')->get();
        return response()->json($categorias, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'Nombre' => 'required|string|unique:Categorias'
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $input = $request->all();
        $categorias = Categoria::create($input);
        return response()->json([
            'message' => 'Categoria creada con exito!'
        ], 201);
    }

    public function update(Request $request, Categoria $categoria)
    {
        //
    }
    
    public function destroy(Categoria $categoria)
    {
        //
    }
}
