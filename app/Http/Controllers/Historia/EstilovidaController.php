<?php

namespace App\Http\Controllers\Historia;


use App\Modelos\Estilovida;
use Illuminate\Http\Request;
use App\Modelos\citapaciente;
use App\Http\Controllers\Controller;

class EstilovidaController extends Controller
{
   
    public function all()
    {
        //
    }

    public function store(Request $request, citapaciente $citapaciente)
    {
        
        if(!$this->isOpenCita($citapaciente->Estado_id)){
            return response()->json([
                'message' => '¡La historia del paciente no se encuentra activa!'
            ], 422);
        }
        Estilovida::create([
            'Citapaciente_id'           => $citapaciente->id,
            'Dietasaludable'            => $request->Dietasaludable,
            'Suenoreparador'            => $request->Suenoreparador,
            'Duermemenoseishoras'       => $request->Duermemenoseishoras,
            'Altonivelestres'           => $request->Altonivelestres,
            'Actividadfisica'           => $request->Actividadfisica,
            'Frecuenciasemana'          => $request->Frecuenciasemana,
            'Duracion'                  => $request->Duracion,
            'Fumacantidad'              => $request->Fumacantidad,
            'Fumainicio'                => $request->Fumainicio,
            'Fumadorpasivo'             => $request->Fumadorpasivo,
            'Cantidadlicor'             => $request->Consumelicor,
            'Licorfrecuencia'           => $request->Licorfrecuencia,
            'Consumopsicoactivo'        => $request->Consumopsicoactivo,
            'Psicoactivocantidad'       => $request->Psicoactivocantidad,
            'Estilovidaobservaciones'   => $request->Estilovidaobservaciones
        ]);

        return response()->json(['message' => 'Estilo de vida guardado con exito!'], 201);
    }

    public function getLifeStyle(citapaciente $citapaciente) {

        $estilovida = Estilovida::select([  
            'Dietasaludable',
            'Suenoreparador',         
            'Duermemenoseishoras',     
            'Altonivelestres',    
            'Actividadfisica',        
            'Frecuenciasemana',        
            'Duracion',       
            'Fumacantidad',            
            'Fumainicio',           
            'Fumadorpasivo',           
            'Cantidadlicor',        
            'Licorfrecuencia',         
            'Consumopsicoactivo',      
            'Psicoactivocantidad',     
            'Estilovidaobservaciones' 
        ])
        ->where('Citapaciente_id', $citapaciente->id)
                ->first();

        return response()->json([ 'estilovida' => $estilovida, ], 201);
    }

    public function show(Estilovida $estilovida)
    {
        //
    }

    private function isOpenCita($estado){
        if ($estado == 8) {
            return true;
        }
        return false;
    }

    
}
