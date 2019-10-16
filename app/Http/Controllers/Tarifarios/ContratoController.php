<?php

namespace App\Http\Controllers\Tarifarios;

use App\Modelos\Contrato;
use App\Modelos\Cup;
use App\Modelos\Sedeproveedore;
use App\Modelos\Cupservicio;
use App\Modelos\Tarifario;
use App\Modelos\Familia;
use App\Modelos\Codigomanual;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ContratoController extends Controller
{
    public function all(Request $request)
    {
        $contrato = Contrato::select(['Contratos.*'])
                            ->join('Sedeproveedores', 'Contratos.Sedeproveedor_id', 'Sedeproveedores.id')
                            ->where('Contratos.Estado_id', 1)
                            ->where('Sedeproveedores.id', $request->Sedeproveedor_id)
                            ->get();
        return response()->json($contrato, 200);
    }

    
    public function unidadFuncionalContrato(Contrato $contrato){
        $unidadfuncionales = Familia::select(['familias.*'])
                ->join('contratofamilias as cf','cf.Familia_id','familias.id')
                ->where('cf.Contrato_id', $contrato->id)
                ->get();
        return response()->json($unidadfuncionales, 200);
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        if($request->pleno || $request->Manual == 'Tarifa Propia'){
            $input['Tarifa'] = '0';
        }
        $contrato = Contrato::create($input);
        return response()->json([
            'message' => 'Contrato creado con Exito!'
        ], 201);
    }

    public function update(Request $request, Contrato $contrato)
    {
        if($request->pleno || $request->Manual == 'Tarifa Propia'){
            $request['Tarifa'] = 0;
        }

        $contrato->update($request->all());

        // $tarifarios = Tarifario::where('Contrato_id',$contrato->id)->get();
        // $signo = $contrato->Tarifa[0];
        // if($signo == '-' || $signo == '+'){
        //     $tarifa = substr($contrato->Tarifa, 1);
        // }else{
        //     $tarifa = $contrato->Tarifa;
        // }

        // foreach ($tarifarios as $tarifario) {
        //     if($contrato->Manual == 'Tarifa Propia'){
               
        //         $tarifario->update([
        //             'Tarifa' => $contrato->Tarifa,
        //             'Valor' => 0
        //         ]);
    
        //     }else{
        //         $codigo = Codigomanual::join('tipomanuales as tm','Codigomanuals.Tipomanual_id','tm.id')
        //                             ->where('Codigomanuals.Cup_id', $tarifario->Cup_id)
        //                             ->where('tm.Nombre', $contrato->Manual)
        //                             ->first();
                
        //         if(isset($codigo)){
        //             if($signo == '-'){
        //                 $valor = $codigo->Valor - ($codigo->Valor * $tarifa/100);
        //             }else{
        //                 $valor = ($codigo->Valor * $tarifa/100) + $codigo->Valor;
        //             }
        //         }else{
        //             $valor = 0;
        //         }
        //         $valor = round($valor);
        //         $tarifario->update([
        //             'Tarifa' => $contrato->Tarifa,
        //             'Valor' => $valor
        //         ]);
        //     }
        // }
        
        
        return response()->json([
            'message' => 'Tarifa guardada con Exito!'
        ], 200);

    }

    public function disable(Contrato $contrato){
        $contrato->update([
            'Estado_id' => 2
        ]);

        return response()->json([
            'message' => 'Contrato deshabilitado!'
        ], 200);
    }

    public function destroy(Contrato $contrato)
    {
        //
    }

    public function saveTarifa(Request $request, Contrato $contrato){
        //$contrato->tarifarios()->forceDelete();
        $contrato->familias()->detach();

        foreach ($request->opcUnidadFuncional as $unidadfuncional) {
            $contrato->familias()->attach($unidadfuncional['id']);
            if($contrato->Manual == 'Tarifa Propia'){
                $this->saveTarifaPropia($request,$contrato,$unidadfuncional);
            }else{
                $this->saveManual($request,$contrato,$unidadfuncional);
            }
        }
        
        return response()->json([
            'message' => 'Tarifa guardada con Exito!'
        ], 201);

    }
    public function saveTarifaPropia($request,$contrato,$uf=null){
        if(isset($uf)){
            $all = $uf['all'];
            $Familia_id = $uf['id'];
        }else{
            $all = $request->all;
            $Familia_id = $request->id;
        }
        if ($all){
            $cups = Cup::select(['cups.*'])
                    ->join('cupfamilias as cf','cf.Cup_id','cups.id')
                    ->where('cf.Familia_id',$Familia_id)
                    ->get();
            
            foreach ($cups as $cup) {
                if($contrato->Ambito == 'Mixta'){
                    Tarifario::where('Cup_id',$cup->id)->where('Sedeproveedor_id',$contrato->Sedeproveedor_id)->delete();
                }else{
                    Tarifario::where('Cup_id',$cup->id)->where('Sedeproveedor_id',$contrato->Sedeproveedor_id)->where('Ambito','Mixta')->delete();
                }
                $isTarifa = Tarifario::where('Cup_id',$cup->id)->where('Sedeproveedor_id',$contrato->Sedeproveedor_id)->where('Ambito',$contrato->Ambito)->first();

                if(!isset($isTarifa)){

                    Tarifario::create([
                        'Cup_id' => $cup->id,
                        'Sedeproveedor_id' => $contrato->Sedeproveedor_id,
                        'Fechainicio' => date('Y-m-d'),
                        'Fechafinal' => date('Y-m-d'),
                        'Tarifa' => $contrato->Tarifa,
                        'Manual' => $contrato->Manual,
                        'Ambito' => $contrato->Ambito,
                        'Valor' => 0,
                        'Estado_id' => 1
                    ]);
                }else{
                    $isTarifa->update([
                        'Fechainicio' => date('Y-m-d'),
                        'Fechafinal' => date('Y-m-d'),
                        'Tarifa' => $contrato->Tarifa,
                        'Manual' => $contrato->Manual,
                        'Ambito' => $contrato->Ambito,
                        'Valor' => 0,
                        'Estado_id' => 1
                    ]);
                }
            }
        }else{
            if(isset($uf)){
                $cup1 = $unidadfuncional['cup1'];
                $cup2 = $unidadfuncional['cup2'];
            }else{
                $cup1 = $request->cup1;
                $cup2 = $request->cup2;
            }
            $rango1 = Cup::find($cup1);
            $rango2 = Cup::find($cup2);

            if($rango1->id <= $rango2->id){
                $id1 = $rango1->id;
                $id2 = $rango2->id;
            }else{
                $id1 = $rango2->id;
                $id2 = $rango1->id;
            }
            $cups = Cup::select(['cups.*'])
                        ->join('cupfamilias as cf','cf.Cup_id','cups.id')
                        ->where('cups.id','>=',$id1)
                        ->where('cups.id','<=',$id2)
                        ->where('cf.Familia_id',$Familia_id)
                        ->get();

            foreach ($cups as $cup) {
                
                if($contrato->Ambito == 'Mixta'){
                    Tarifario::where('Cup_id',$cup->id)->where('Sedeproveedor_id',$contrato->Sedeproveedor_id)->delete();
                }else{
                    Tarifario::where('Cup_id',$cup->id)->where('Sedeproveedor_id',$contrato->Sedeproveedor_id)->where('Ambito','Mixta')->delete();
                }
                $isTarifa = Tarifario::where('Cup_id',$cup->id)->where('Sedeproveedor_id',$contrato->Sedeproveedor_id)->where('Ambito',$contrato->Ambito)->first();

                if(!isset($isTarifa)){
                    Tarifario::create([
                        'Cup_id' => $cup->id,
                        'Sedeproveedor_id' => $contrato->Sedeproveedor_id,
                        'Fechainicio' => date('Y-m-d'),
                        'Fechafinal' => date('Y-m-d'),
                        'Tarifa' => $contrato->Tarifa,
                        'Manual' => $contrato->Manual,
                        'Ambito' => $contrato->Ambito,
                        'Valor' => 0,
                        'Estado_id' => 1
                    ]);
                }else{
                    $isTarifa->update([
                        'Fechainicio' => date('Y-m-d'),
                        'Fechafinal' => date('Y-m-d'),
                        'Tarifa' => $contrato->Tarifa,
                        'Manual' => $contrato->Manual,
                        'Ambito' => $contrato->Ambito,
                        'Valor' => 0,
                        'Estado_id' => 1
                    ]);
                }
            }
        }
    }
    public function saveManual($request, $contrato,$uf=null){
        $signo = $contrato->Tarifa[0];
        if($signo == '-' || $signo == '+'){
            $tarifa = substr($contrato->Tarifa, 1);
        }else{
            $tarifa = $contrato->Tarifa;
        }
        if(isset($uf)){
            $all = $uf['all'];
            $Familia_id = $uf['id'];
            $cup1 = $uf['cup1'];
            $cup2 = $uf['cup2'];
        }else{
            $all = $request->all;
            $Familia_id = $request->id;
            $cup1 = $request->cup1;
            $cup2 = $request->cup2;
        }
        if ($all) {

            $cups = Cup::select(['cups.*'])
                        ->join('cupfamilias as cf','cf.Cup_id','cups.id')
                        ->where('cf.Familia_id', $Familia_id)
                        ->get();
                        
            foreach ($cups as $cup) {
                $codigomanual = Codigomanual::select(['codigomanuals.*'])
                            ->join('tipomanuales as tm','codigomanuals.Tipomanual_id','tm.id')
                            ->where('tm.Nombre', $contrato->Manual)
                            ->where('codigomanuals.Cup_id', $cup->id)
                            ->first();

                if(isset($codigomanual)){
                    if($signo == '-'){
                        $valor = $codigomanual->Valor - ($codigomanual->Valor * $tarifa/100);
            
                    }else{
                        $valor = ($codigomanual->Valor * $tarifa/100) + $codigomanual->Valor;
            
                    }
                    $valor = round($valor);
                }else{
                    $valor = 0;
                }
                if($contrato->Ambito == 'Mixta'){
                    Tarifario::where('Cup_id',$cup->id)->where('Sedeproveedor_id',$contrato->Sedeproveedor_id)->delete();
                }else{
                    Tarifario::where('Cup_id',$cup->id)->where('Sedeproveedor_id',$contrato->Sedeproveedor_id)->where('Ambito','Mixta')->delete();
                }
                $isTarifa = Tarifario::where('Cup_id',$cup->id)->where('Sedeproveedor_id',$contrato->Sedeproveedor_id)->where('Ambito',$contrato->Ambito)->first();
                if(!isset($isTarifa)){
                    Tarifario::create([
                        'Cup_id' => $cup->id,
                        'Sedeproveedor_id' => $contrato->Sedeproveedor_id,
                        'Fechainicio' => date('Y-m-d'),
                        'Fechafinal' => date('Y-m-d'),
                        'Tarifa' => $contrato->Tarifa,
                        'Manual' => $contrato->Manual,
                        'Ambito' => $contrato->Ambito,
                        'Valor' => $valor,
                        'Estado_id' => 1
                    ]);
                }else{
                    $isTarifa->update([
                        'Fechainicio' => date('Y-m-d'),
                        'Fechafinal' => date('Y-m-d'),
                        'Tarifa' => $contrato->Tarifa,
                        'Manual' => $contrato->Manual,
                        'Ambito' => $contrato->Ambito,
                        'Valor' => $valor,
                        'Estado_id' => 1
                    ]);
                }
            }
        } else {
            $rango1 = Cup::find($cup1);
            $rango2 = Cup::find($cup2);
            if($rango1->id <= $rango2->id){
                $id1 = $rango1->id;
                $id2 = $rango2->id;
            }else{
                $id1 = $rango2->id;
                $id2 = $rango1->id;
            }
            $cups = Cup::select(['cups.*'])
                        ->join('cupfamilias as cf','cf.Cup_id','cups.id')
                        ->where('cups.id','>=',$id1)
                        ->where('cups.id','<=',$id2)
                        ->where('cf.Familia_id',$Familia_id)
                        ->get();
            foreach ($cups as $cup) {
                $codigo = Codigomanual::join('tipomanuales as tm','Codigomanuals.Tipomanual_id','tm.id')
                                    ->where('Codigomanuals.Cup_id', $cup->id)
                                    ->where('tm.Nombre', $contrato->Manual)
                                    ->first();
                if(isset($codigo)){
                    if($signo == '-'){
                        $valor = $codigo->Valor - ($codigo->Valor * $tarifa/100);
                    }else{
                        $valor = ($codigo->Valor * $tarifa/100) + $codigo->Valor;
                    }

                    $valor = round($valor);

                }else{
                    $valor = 0;
                }

                if($contrato->Ambito == 'Mixta'){
                    Tarifario::where('Cup_id',$cup->id)->where('Sedeproveedor_id',$contrato->Sedeproveedor_id)->delete();
                }else{
                    Tarifario::where('Cup_id',$cup->id)->where('Sedeproveedor_id',$contrato->Sedeproveedor_id)->where('Ambito','Mixta')->delete();
                }
                $isTarifa = Tarifario::where('Cup_id',$cup->id)->where('Sedeproveedor_id',$contrato->Sedeproveedor_id)->where('Ambito',$contrato->Ambito)->first();

                if(!isset($isTarifa)){
                    Tarifario::create([
                        'Cup_id' => $cup->id,
                        'Sedeproveedor_id' => $contrato->Sedeproveedor_id,
                        'Fechainicio' => date('Y-m-d'),
                        'Fechafinal' => date('Y-m-d'),
                        'Tarifa' => $contrato->Tarifa,
                        'Manual' => $contrato->Manual,
                        'Ambito' => $contrato->Ambito,
                        'Valor' => $valor,
                        'Estado_id' => 1
                    ]);
                }else{
                    $isTarifa->update([
                        'Fechainicio' => date('Y-m-d'),
                        'Fechafinal' => date('Y-m-d'),
                        'Tarifa' => $contrato->Tarifa,
                        'Manual' => $contrato->Manual,
                        'Ambito' => $contrato->Ambito,
                        'Valor' => $valor,
                        'Estado_id' => 1
                    ]);
                }
            }
        }
    }

    public function addTarifa(Request $request, Contrato $contrato){

        $unidadfuncionales = Familia::select(['familias.*'])
                ->join('contratofamilias as cf','cf.Familia_id','familias.id')
                ->where('cf.Contrato_id', $contrato->id)
                ->where('familias.id', $request->id)
                ->first();
               
        if(!isset($unidadfuncionales)){

            $contrato->familias()->attach($request->id);
        }

        if($contrato->Manual == 'Tarifa Propia'){
            $this->saveTarifaPropia($request,$contrato);
        }else{
            $this->saveManual($request,$contrato);
        }

        return response()->json([
            'message' => '¡Tarifa unidad funcional agregada con Exito!'
        ], 201);
        
    }

    public function allTarifa(Sedeproveedore $sede){
        $tarifas = Tarifario::select(['tarifarios.*','c.Codigo','c.Nombre as Cup','cf.Familia_id'])
                    ->join('cups as c','tarifarios.Cup_id','c.id')
                    ->join('cupfamilias as cf','cf.Cup_id','c.id')
                    ->join('familias as f','cf.Familia_id','f.id')
                    ->where('tarifarios.Sedeproveedor_id',$sede->id)
                    ->where('f.Tipofamilia_id',4)
                    ->where('tarifarios.Estado_id', 1)
                    ->get();

        return response()->json($tarifas, 201);
    }

    public function updateTarifa(Contrato $contrato, $cup, Request $request){
        $tarifa = Tarifario::find($cup);
        $tarifa->update([
            'Valor' => $request->Valor
        ]);

        return response()->json([
            'message' => 'Tarifa actualizada'
        ], 201);
    }

    public function disableTarifa(Contrato $contrato,Tarifario $tarifa){
        $tarifa->update([
            'Estado_id' => 2
        ]);

        return response()->json([
            'message' => 'Tarifa desabilitada'
        ], 201);
    }

    public function removeunidadFuncionalContrato(Contrato $contrato, Request $request){
        $cupsfamilia = Familia::select(['familias.*','cf.Cup_id'])
                    ->join('cupfamilias as cf','cf.Familia_id','familias.id')
                    ->where('familias.id', $request->id)
                    ->get();
        
        foreach ($cupsfamilia as $cup) {
            $tarifa = Tarifario::where('Cup_id', $cup->Cup_id)
                                    ->where('Sedeproveedor_id',$contrato->Sedeproveedor_id)
                                    ->where('Ambito',$contrato->Ambito)
                                    ->first();

            if(isset($tarifa)){
                $tarifa->update([
                    'Estado_id' => 2
                ]);
            }
        }

        $contrato->familias()->detach([$request->id]);
        
        return response()->json([
            'message' => 'Unidad funcional deshabilitada'
        ], 201);
    }
}
