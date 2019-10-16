<?php

namespace App\Http\Controllers\Bodegas;

use App\Modelos\Notastransacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Modelos\Movimiento;

class NotasController extends Controller
{
    public function all(Movimiento $movimiento)
    {
        $nota = Notastransacion::select(['Notastransacions.*', 'users.name as Nombreuser', 'users.apellido as Apellidouser' ])
        ->join('users', 'Notastransacions.Usuario_id', 'users.id')
        ->where('Notastransacions.Movimiento_id', $movimiento->id)
        ->get();
        return response()->json($nota, 200);
    }

    public function store(Request $request, Movimiento $movimiento)
    {
        $validate = Validator::make($request->all(), [
            'Nombre' => 'required|string',
            'Descripcion' => 'required|string'
        ]);
        if ($validate->fails()) {
            $errores = $validate->errors();
            return response()->json($errores, 422);
        }
        $nota = Notastransacion::create([
            'usuario_id' => auth()->user()->id,
            'Movimiento_id' => $movimiento->id,
            'Nombre' => $request->Nombre, 
            'Descripcion' => $request->Descripcion,
        ]);
        return response()->json([
            'message' => 'Nota creada con exito!'
        ], 201);
    }
    
    public function update(Request $request, Notastransacion $notastransacion)
    {
        $notastransacion->update([
            'Nombre' => $request->Nombre,
            'Descripcion' => $request->Descripcion,
        ]);
        return response()->json([
            'message' => 'Nota actualizada con exito!'
        ]);
    }
}
