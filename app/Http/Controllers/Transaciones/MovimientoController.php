<?php

namespace App\Http\Controllers\Transaciones;

use App\Modelos\Codesumi;
use App\Modelos\Tipotransacion;
use App\Modelos\Detallearticulo;
use App\Modelos\Movimiento;
use Illuminate\Http\Request;
use App\Modelos\bodegarticulo;
use App\Modelos\Lote;
use App\Modelos\Orden;
use App\Modelos\Bodega;
use App\Modelos\Detaarticulorden;
use App\Modelos\Bodegatransacion;
use App\Http\Controllers\Controller;
use App\Modelos\Notastransacion;
use App\Modelos\Ordencompra;
use Illuminate\Support\Facades\Auth;
use phpseclib\Crypt\Random;
use Rap2hpoutre\FastExcel\FastExcel;

class MovimientoController extends Controller
{
    private $_index = 1;
    private $_inconsistencias = [];

    public function all(Bodega $bodega){
        $movimiento = Movimiento::select(['Movimientos.*', 'Transacions.Nombre as NombreTransacion', 'Tipos.Nombre as NomTipotransacion', 
                                          'Users.name as NomusuarioCrea', 'Estados.Nombre as NomEstado', 'Reps.Nombre as NomReps', 
                                          'BodegaOrigen.Nombre as BodegaOrigen', 'BodegaDestino.Nombre as BodegaDestino', 'Prestadores.Nombre as NomPrestador'])
        ->join('Tipotransacions', 'Movimientos.Tipotransacion_id', 'Tipotransacions.id')
        ->join('Transacions', 'Tipotransacions.Transacion_id', 'Transacions.id')
        ->join('Tipos', 'Tipotransacions.Tipo_id', 'Tipos.id')
        ->leftJoin('Reps', 'Movimientos.Reps_id', 'Reps.id')
        ->join('Users', 'Movimientos.usuario_id', 'Users.id')
        ->join('Estados', 'Movimientos.Estado_id', 'Estados.id')
        ->leftJoin('Bodegas as BodegaOrigen', 'Movimientos.BodegaOrigen_id', 'BodegaOrigen.id')
        ->leftJoin('Bodegas as BodegaDestino', 'Movimientos.BodegaDestino_id', 'BodegaDestino.id')
        ->leftJoin('Prestadores', 'Movimientos.Prestador_id', 'Prestadores.id')
        ->get();
        return response()->json($movimiento, 200);
    }

    public function dispensar(Request $request){

        $movimiento = Movimiento::create([
            'Tipotransacion_id' => 3,
            'Orden_id' => $request[0]['Orden_id'],
            'usuario_id' => auth()->user()->id,
        ]);

        foreach ($request->all() as $medicamento) {
            $sum = 0;
            foreach ($medicamento['lotes'] as $lote) {
                $lot = Lote::find($lote['id']);
                $bodegarticulo = bodegarticulo::find($lot->Bodegarticulo_id);
                $bodegarticulo->update([
                    'Stock' => $bodegarticulo->Stock - $lote['cantidad']
                ]);
                $sum += $lote['cantidad'];
                $lot->update([
                    'Cantidadisponible' => $lot->Cantidadisponible - $lote['cantidad'], 
                ]);
                $bodegatransacion = Bodegatransacion::where('Bodegarticulo_id', $bodegarticulo->id)->orderBy('id','DESC')->first();
                if(!isset($bodegatransacion)){
                    $precio = 0;
                    $valorTra = 0;
                    $valorTotal = 0;
                    $valorProm = 0;
                }else{
                    $precio = round($bodegatransacion->Valorpromedio);
                    $valorTra = $precio * $lote['cantidad'];
                    $valorTotal = $bodegatransacion->Valortotal - $valorTra;
                    $valorProm = round($valorTotal / $bodegarticulo->Stock, 2);
                }

                Bodegatransacion::create([
                    'Lote_id'  => $lot->id,
                    'Movimiento_id' => $movimiento->id,
                    'Cantidadtotal' => $lote['pEntregar'], //cantidad real que debería ser movida en el inventario
                    'CantidadtotalFactura' => $lote['cantidad'], //cantidad que se esta moviendo
                    'Precio' => $precio,
                    'Cantidadtotalinventario'=> $bodegarticulo->Stock,
                    'Valor'=> $valorTra,
                    'Valortotal'=> $valorTotal,
                    'Valorpromedio' => $valorProm,
                    'Estado_id' => 1,
                    'Bodegarticulo_id' => $bodegarticulo->id
                ]);
            }
            $mediOrden = Detaarticulorden::find($medicamento['id']);
            if($mediOrden->Cantidadmensualdisponible == $sum){
                $mediOrden->update([
                    'Estado_id' => 17,
                    'Cantidadmensualdisponible' => 0

                ]);
            }else{
                $mediOrden->update([
                    'Estado_id' => 19,
                    'Cantidadmensualdisponible' => $mediOrden->Cantidadmensualdisponible - $sum
                ]);
            }
            $orden = Orden::select(['ordens.*','to.Nombre as tipo_orden'])
                            ->join('cita_paciente as cp','ordens.Cita_id','cp.id')
                            ->join('pacientes as p','cp.Paciente_id','p.id')
                            ->join('tipordens as to','to.id','ordens.Tiporden_id')
                            ->join('detaarticulordens as do','do.Orden_id','ordens.id')
                            ->with(['detaarticulordens' => function($query) {
                                $query->select('detaarticulordens.*','cs.Codigo as Codigo','cs.Nombre as medicamento')
                                        ->join('codesumis as cs','detaarticulordens.Codesumi_id','cs.id')
                                        ->whereIn('detaarticulordens.Estado_id', [1,18,19])
                                        ->get();
                            }])
                            ->whereHas('detaarticulordens',function ($query){
                                $query->whereIn('Estado_id', [1,18,19]);
                            })
                            ->distinct()
                            ->where('ordens.id',$mediOrden->Orden_id)
                            ->first();
            if(isset($orden)){
                $orden->update([
                    'Estado_id' => 18,
                ]);
            }else{
                $orden->update([
                    'Estado_id' => 17,
                ]);
            }
            if(isset($orden->paginacion)){
                $pagination = explode('/', $orden->paginacion);

                if(isset($pagination[1])){
                    $j = intval($pagination[0]) + 1;
                    for ($i = $j; $i <= intval($pagination[1]); $i++) {
                        $date = date('Y-m-d',strtotime("+".$i-intval($pagination[0])." month"));
                        $o = Orden::where('paginacion',$i."/".$pagination[1])->where('Cita_id',$orden->Cita_id)->first();
                        $o->update(['Fechaorden' => $date]);
                    }
                }
            }
        }

        return response()->json([
            'message' => 'Dispensación realizada con exito!',
        ], 201);
    }

    public function store(Request $request, Bodega $bodega) {

        /*$Numfacturazeus = isset($request->Numfacturazeus) ? $request->Numfacturazeus : 'N/A';*/
        /*$Numfactura = isset($request->Numfactura) ? $request->Numfactura : 'N/A';*/

        $movimiento = Movimiento::create([
            'Tipotransacion_id' => $request->Tipotransacion_id,
            //'Numfacturazeus' => $Numfacturazeus,
            //'Numfactura' => $Numfactura,
            'prestador_id' => $request->prestador_id,
            'BodegaOrigen_id' => $request->BodegaOrigen_id,
            'BodegaDestino_id' => $request->BodegaDestino_id,
            'Reps_id' => $request->Reps_id,
            'usuario_id' => auth()->user()->id,
            'Bodegadestino_id' => $request->Bodegadestino_id,
            'Estado_id' => 15

        ]);



        forEach($request->bodegarticulos as $bodegarticulo){
            
        $stock = bodegarticulo::select('Stock', 'id')
                                ->where('id',$bodegarticulo['Bodegarticulo_id'])
                                ->first();

        $valoranterior = Bodegatransacion::select('Valortotal', 'Valor')
                                ->where('Bodegarticulo_id',$bodegarticulo['Bodegarticulo_id'])
                                ->orderBy('id', 'DESC')
                                ->limit(1)
                                ->first();
        $tipotansacion1 = Tipotransacion::select('id')
                                 ->where('Tipotransacions.id', $request->Tipotransacion_id)
                                 ->first();

        if ($tipotansacion1->id == '2') {
            $valor =  - $bodegarticulo['Cantidadtotal'] * $bodegarticulo['Precio'];
            $salida = -$bodegarticulo['Cantidadtotal'];
            
        }else {
            $valor = $bodegarticulo['Cantidadtotal'] * $bodegarticulo['Precio'];
            $salida = $bodegarticulo['Cantidadtotal'];
            //$facturaEntrada = isset($bodegarticulo['CantidadtotalFactura'])? $bodegarticulo['CantidadtotalFactura']  :'';
        }

        if (isset($valoranterior)) {
           $valortotal =  $valoranterior->Valortotal + $salida * $bodegarticulo['Precio'];
        }else {
            $valortotal = $salida * $bodegarticulo['Precio'];
        }

        /*if (isset($bodegarticulo['Fvence'])) {
            try {
                $date = new \DateTime($bodegarticulo['Fvence']);
                $date_format = $date->format('Y-m-d');
            } catch (Exception $e) {
                $date_format = "2099-01-01";
            }

        } else {
            $date_format = "2099-01-01";
        }*/

          $bodega_guerdada =  Bodegatransacion::create([
                'Movimiento_id' => $movimiento->id,
                'Cantidadtotal' => $salida,
                'Precio' => $bodegarticulo['Precio'],
                'Bodegarticulo_id' => 1,
                'Cantidadtotalinventario'=> $stock->Stock + $salida,
                'Valor'=> $valor,
                'Valortotal'=> $valortotal,
                'CantidadtotalFactura' => 0,
                'Estado_id' => 15
            ]);

            $bodega_guerdada->update([
                'Bodegarticulo_id' => 1
            ]);

            /*$prueba = Bodegatransacion::all()->last();
            $promedio = $prueba->Valortotal / $prueba->Cantidadtotalinventario;

            $bodegatransacion = Bodegatransacion::where('id', $prueba->id)->first();
            if (isset($bodegatransacion)){
                $bodegatransacion->Valorpromedio = $promedio;
                $bodegatransacion->save();
            }*/

        }
        
        return response()->json([
            'message' => 'Movimiento con exito!'
        ], 201);

    }

    public function entradaFactura(Request $request, Bodega $bodega){
        $movimiento = Movimiento::create([
            'Tipotransacion_id' => 4,
            'Numfacturazeus' => $request->Numfacturazeus,
            'Numfactura' => $request->Numfactura,
            'Estado_id' => 1,
            'usuario_id' => auth()->user()->id,
            'BodegaOrigen_id' => $bodega->id
        ]);
        foreach ($request->selected as $item) {
            $articulo = bodegarticulo::find($item['bodegaarticulo_id']);
            $lote = Lote::where('Numlote',$item['Lote'])->where('Bodegarticulo_id', $articulo->id)->first();
            if(!isset($lote)){
                $lote = Lote::create([
                    'Numlote' => $item['Lote'], 
                    'Fvence' => $item['Fvence'], 
                    'Cantidadisponible' => 0, 
                    'Bodegarticulo_id' => $articulo->id, 
                    'Estado_id' => 1
                ]);
            }
            
            $bodegatransacion = Bodegatransacion::where('Bodegarticulo_id', $articulo->id)->orderBy('id','DESC')->first();
            if(!isset($bodegatransacion)){
                $valorAnt = 0;
            }else{
                $valorAnt = $bodegatransacion->Valortotal;
            }
            $valor = $item['Precio'] * $item['CantidadtotalFactura'];
            $valortotal = $valor + $valorAnt;
            $cantidadInvetario = $articulo->Stock + $item['CantidadtotalFactura'];
            $valorprom = $valortotal/$cantidadInvetario;
            Bodegatransacion::create([
                'Lote_id' => $lote->id,
                'Movimiento_id' => $movimiento->id,
                'Cantidadtotal' => $item['Cantidad'],
                'CantidadtotalFactura' => $item['CantidadtotalFactura'], 
                'Cantidadtotalinventario' => $cantidadInvetario, 
                'Precio' => $item['Precio'],
                'Valor' => $valor,
                'Valortotal' => $valortotal,
                'Valorpromedio' => $valorprom,
                'Estado_id' => 1,
                'Bodegarticulo_id' => $articulo->id
            ]);

            $ordencompra = Ordencompra::find($item['id']);
            $diff = $ordencompra->Cantidad - $item['CantidadtotalFactura'];
            if($diff == 0){
                $state = 2;
            }else{
                $state = 7;
            }
            $ordencompra->update([
                'Cantidad' => $diff,
                'Estado_id' => $state,
            ]);

            $lote->update([
                'Cantidadisponible' => $lote->Cantidadisponible + $item['CantidadtotalFactura'],
            ]);

            $articulo->update([
                'Stock' => $articulo->Stock + $item['CantidadtotalFactura']
            ]);
        }
        return response()->json([
            'message' => '¡Factura ingresada con exito!'
        ], 200);
    }

    public function articulos(Movimiento $movimiento){
        $articulos = Bodegatransacion::select(['Detallearticulos.CUM_completo','Detallearticulos.Principio_Activo', 
                                               'Detallearticulos.Unidad_Medida','Detallearticulos.Nombresumi',
                                               'Detallearticulos.Cantidad', 'Detallearticulos.Forma_Farmaceutica',
                                               'Bodegatransacions.Cantidadtotal', 'Bodegatransacions.CantidadtotalFactura',
                                               'Bodegatransacions.Precio', 'Bodegatransacions.id', 'Bodegatransacions.Bodegarticulo_id',
                                               'Lotes.Numlote'])
        ->join('Bodegarticulos', 'Bodegatransacions.Bodegarticulo_id', 'Bodegarticulos.id')
        ->leftJoin('Lotes', 'Bodegatransacions.Lote_id', 'Lotes.id')
        ->join('Detallearticulos', 'Bodegarticulos.Detallearticulo_id', 'Detallearticulos.id')
        ->where('Bodegatransacions.Movimiento_id', $movimiento->id)
        ->get();
        return response()->json($articulos, 200);
    }

    public function update(Request $request, Movimiento $movimiento){
        $movimiento->update($request->all());
        return response()->json([
            'message' => 'Movimiento actualizado con exito!'
        ]);
    }

    public function available(Request $request, Movimiento $movimiento){
        $estado_available = 7;

        $bodegatransacion_a = Bodegatransacion::select('Cantidadtotal', 'Bodegarticulo_id', 'id')
        ->where('Movimiento_id', $movimiento->id)
        ->get();

        forEach($bodegatransacion_a as $bodegatransacion_c){

            $bodegatransacion_c->update([
                'Estado_id' => $estado_available
            ]);
        }

        $movimiento->update([
            'Estado_id' => $estado_available
        ]);

        
        return response()->json([
            'message' => 'Movimiento Actualizado con Exito!'
        ], 200);
    }

    public function entrace(Request $request, Movimiento $movimiento) {
        $estado_available = 3;

        $bodegatransacion_a = Bodegatransacion::select('Cantidadtotal', 'Bodegarticulo_id', 'id')
            ->where('Movimiento_id', $movimiento->id)
            ->get();

        forEach($bodegatransacion_a as $bodegatransacion_c){

            $bodegatransacion_c->update([
                'Estado_id' => $estado_available,
                'CantidadtotalFactura' => 0
            ]);
        }


        forEach($request->bodega_transaccions as $bodegatransacion_r){

            $bodegarticulo = bodegarticulo::where('id', $bodegatransacion_r['Bodegarticulo_id'])
                ->first();

            $bodegarticulo->Stock =  $bodegarticulo->Stock + $bodegatransacion_r['CantidadtotalFactura'];
            $bodegarticulo->save();


            $loteencontrado = Lote::where('Numlote', $bodegatransacion_r['Numlote'])
                ->where('Bodegarticulo_id', $bodegatransacion_r['Bodegarticulo_id'])
                ->first();
            if ($loteencontrado == null) {
                $loteencontrado = Lote::create([
                    'Numlote'           => $bodegatransacion_r['Numlote'],
                    'Fvence'            => '2019-01-01',
                    'Cantidadisponible' =>  $bodegatransacion_r['CantidadtotalFactura'],
                    'Bodegarticulo_id'  =>  $bodegatransacion_r['Bodegarticulo_id']
                ]);
            } else {
                $loteencontrado->update('Cantidadisponible', intval($loteencontrado->Cantidadisponible) + intval($bodegarticulo['Cantidadtotal']));
            }

            $bodegatransacion_c->update([
                'Estado_id' => $estado_available,
                'Lote_id' => $loteencontrado->id,
                'CantidadtotalFactura' => $bodegatransacion_r['CantidadtotalFactura']
            ]);
        }



        $movimiento->update([
            'Estado_id' => $estado_available
        ]);


        return response()->json([
            'message' => 'Movimiento Actualizado con Exito!'
        ], 200);
    }

    public function cancelar(Request $request, Movimiento $movimiento){

         $notatransacion = Notastransacion::create([
             'usuario_id' => auth()->user()->id,
             'Movimiento_id' => $movimiento->id,
             'Descripcion' => $request->Descripcion
         ]);

         $estado_cancelado = 6;

         $bodegatransacion_a = Bodegatransacion::select('Cantidadtotal', 'Lote_id', 'id')
             ->where('Movimiento_id', $movimiento->id)
             ->get();

         forEach($bodegatransacion_a as $bodegatransacion_c){

             $bodegatransacion_c->update([
                 'Estado_id' => $estado_cancelado
             ]);

             $movimiento->update([
                 'Estado_id' => $estado_cancelado
             ]);
         }

         return response()->json([
             'message' => 'Movimiento cancelado con Exito!'
         ], 200);

    }

    public function massInvoices(Request $request){
        
        // $lines = (new FastExcel)->import($request->excel);
        $contents = [];
        $rows = [];
        $items = [];
        $lines = [];
        $c = 0;
        $i = 0;
        $file = $request->file('excel');
        $open_file = fopen($file,'r');
        $content = fread($open_file, filesize($request->file('excel')));
        $rows = preg_split('/\r\n/', $content);
        $headers = explode(',',$rows[0]);

        // $this->checkFileNameFields($lines[0]);

        $i = -1;
        foreach ($rows as $row) {
            $i++;
            if($i == 0){
                continue;
            }

            $items[$i] = explode(',',$row);

        }
        $i = 0;
        foreach ($items as $item) {
            if($i == 19){
                $lines[$i][$headers[0]] = $item[0];
            }
            $i++;
        }

        return $lines;

        if(count($this->_inconsistencias) == 0){
            foreach ($lines as $line) {
                $this->_index++;
                $this->checkFileFields($line);
            }
        }
        $this->_index = 1;
        if(count($this->_inconsistencias) == 0){
            foreach ($lines as $line) {
                $this->_index++;
                $this->checkDBFileFields($line);
            }
        }
        
        return response()->json([
            'message' => $this->_inconsistencias
        ], 200);
    }

    private function checkFileNameFields($fields){

        if(!isset($fields['nombre articulo'])){ $this->pushInconsistencia("el campo 'nombre articulo' no existe",1); }

        if(!isset($fields['CODIGO SUMI'])){ $this->pushInconsistencia("el campo 'CODIGO SUMI' no existe",1); }

        if(!isset($fields['fecha de compra'])){ $this->pushInconsistencia("el campo 'fecha de compra' no existe",1); }

        if(!isset($fields['#factura'])){ $this->pushInconsistencia("el campo '#factura' no existe",1); }

        if(!isset($fields['Bodega'])){ $this->pushInconsistencia("el campo 'Bodega' no existe",1); }

        if(!isset($fields['cantidad ordenada'])){ $this->pushInconsistencia("el campo 'cantidad ordenada' no existe",1); }

        if(!isset($fields['cantidad recibida'])){ $this->pushInconsistencia("el campo 'cantidad recibida' no existe",1); }

        if(!isset($fields['vr unitario'])){ $this->pushInconsistencia("el campo 'vr unitario' no existe",1); }

        if(!isset($fields['total'])){ $this->pushInconsistencia("el campo 'total' no existe",1); }

        if(!isset($fields['invima'])){ $this->pushInconsistencia("el campo 'invima' no existe",1); }

        if(!isset($fields['lote'])){ $this->pushInconsistencia("el campo 'lote' no existe",1); }

        if(!isset($fields['fecha de vencimiento'])){ $this->pushInconsistencia("el campo 'fecha de vencimiento' no existe",1); }

        if(!isset($fields['CUM'])){ $this->pushInconsistencia("el campo 'CUM' no existe",1); }

    }

    private function checkFileFields($fields){

        if(trim($fields['nombre articulo']) == ''){ $this->pushInconsistencia("el campo 'nombre articulo' está vacio"); }

        if(trim($fields['CODIGO SUMI']) == ''){ $this->pushInconsistencia("el campo 'CODIGO SUMI' está vacio"); }

        if(trim($fields['fecha de compra']) == ''){ $this->pushInconsistencia("el campo 'fecha de compra' está vacio"); }

        if(trim($fields['#factura']) == ''){ $this->pushInconsistencia("el campo '#factura' está vacio"); }

        if(trim($fields['Bodega']) == ''){ $this->pushInconsistencia("el campo 'Bodega' está vacio"); }

        if(trim($fields['cantidad ordenada']) == ''){ $this->pushInconsistencia("el campo 'cantidada ordenada' está vacio"); }

        if(trim($fields['cantidad recibida']) == ''){ $this->pushInconsistencia("el campo 'cantidad recibida' está vacio"); }

        if(trim($fields['vr unitario']) == ''){ $this->pushInconsistencia("el campo 'vr unitario' está vacio"); }

        if(trim($fields['total']) == ''){ $this->pushInconsistencia("el campo 'total' está vacio"); }

        if(trim($fields['invima']) == ''){ $this->pushInconsistencia("el campo 'invima' está vacio"); }

        if(trim($fields['lote']) == ''){ $this->pushInconsistencia("el campo 'lote' está vacio"); }

        if(trim($fields['fecha de vencimiento']) == ''){ $this->pushInconsistencia("el campo 'fecha de vencimiento' está vacio"); }

        if(trim($fields['CUM']) == ''){ $this->pushInconsistencia("el campo 'CUM' está vacio"); }
    }

    private function checkDBFileFields($fields){
        $endMsg = "' no está en base de datos";
        if(!$this->isDbCodesumi($fields['CODIGO SUMI'])){ $this->pushInconsistencia("el 'CODIGO SUMI' '".$fields['CODIGO SUMI'].$endMsg); }

        if(!$this->isDbBodega($fields['Bodega'])){ $this->pushInconsistencia("la 'Bodega' '".$fields['Bodega'].$endMsg); }

        if(!$this->isDbCUM($fields['CUM'])){ $this->pushInconsistencia("el 'CUM' '".$fields['CUM'].$endMsg); }
    }

    private function isDbCodesumi($codesumi){
        $code = Codesumi::where('Codigo', $codesumi)->first();

        if(isset($code)){ return true; }
        return false;
    }

    private function isDbBodega($bodega){
        $b = Bodega::where('Nombre', $bodega)->first();

        if(isset($b)){ return true; }
        return false;
    }

    private function isDbCUM($CUM){
        $detalle = Detallearticulo::where('CUM_completo', $CUM)->first();

        if(isset($detalle)){ return true; }
        return false;
    }

    private function pushInconsistencia($msg, $type = 2){
        if($type == 1){ array_push($this->_inconsistencias,$msg); }
        else { array_push($this->_inconsistencias,"en la linea ".$this->_index." ".$msg); }
    }

}