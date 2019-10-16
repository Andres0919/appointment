<?php

namespace App\Http\Controllers\Historia;

use App\Modelos\Parentescoantecedente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\citapaciente;
use App\Modelos\Antecedentesparentesco;

class ParentescoantecedeController extends Controller
{
    public function all()
    {
        $Parentescoantecedente = Parentescoantecedente::all();  
        return response()->json($Parentescoantecedente, 200);
    }

    public function store(Request $request, citapaciente $citapaciente)
    {
        
        foreach ($request->all() as $familiar) {
            // return $familiar['familiares'];
          $p =  Parentescoantecedente::create([
                'Antecedente_id' => $familiar['id'],
                'Citapaciente_id' => $citapaciente->id,                
                'Usuario_id' => auth()->user()->id,
                'Descripcion' => $familiar['Descripcion'],
    
            ]);
        foreach ($familiar['familiares'] as $parientes) {
            Antecedentesparentesco::create([
                'Parentesco_id' => $parientes,
                'Parentescotecedentes_id' => $p->id
            ]);
        }
            
    }
        return response()->json([
            'message' => 'Antecedentes guardados con exito!'
        ],201);
    }
}
