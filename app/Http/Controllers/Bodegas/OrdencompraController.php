<?php

namespace App\Http\Controllers\Bodegas;

use App\User;
use App\Modelos\Ordencompra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\bodegarticulo;
use App\Modelos\Bodega;
use Illuminate\Support\Facades\Validator;

class OrdencompraController extends Controller
{
    
    public function allOrdens(Request $request,Bodega $bodega)
    {
        $solicitudes = Ordencompra::select(['ordencompras.id','cs.Nombre','da.CUM_completo','da.Titular','ordencompras.Cantidad'])
                                ->join('bodegarticulos as ba','ordencompras.Bodegarticulo_id','ba.id')
                                ->join('detallearticulos as da','ba.Detallearticulo_id','da.id')
                                ->join('codesumis as cs','da.Codesumi_id','cs.id')
                                ->where('ba.Bodega_id',$request->Bodega_id)
                                ->where('ordencompras.Estado_id',15)
                                ->get();

        return response()->json($solicitudes, 200);
    }

    public function allacepted(Bodega $bodega){
        $solicitudes = Ordencompra::select(['ordencompras.id','ba.id as bodegaarticulo_id','cs.Nombre','da.CUM_completo','da.Titular','ordencompras.Cantidad'])
                                ->join('bodegarticulos as ba','ordencompras.Bodegarticulo_id','ba.id')
                                ->join('detallearticulos as da','ba.Detallearticulo_id','da.id')
                                ->join('codesumis as cs','da.Codesumi_id','cs.id')
                                ->where('ba.Bodega_id',$bodega->id)
                                ->where('ordencompras.Estado_id', 7)
                                ->get();

        return response()->json($solicitudes, 200);
    }

    public function store(Request $request, Bodega $bodega)
    {   
        foreach ($request->bodegarticulos as $bodegarticulo) {
            Ordencompra::create([
                'Cantidad' => $bodegarticulo['Cantidadtotal'],
                'Bodegarticulo_id' => $bodegarticulo['Titular']['Bodegarticulo_id'],
                'Usuario_id' => auth()->user()->id,
            ]);
        }
        
        return response()->json([
            'message' => 'Solucitud de Compra creada con exito!'
        ], 201);
    }

    public function update(Request $request, Ordencompra $ordencompra)
    {
        $ordencompra->update([
            'Cantidad' => $request->Cantidad,
        ]);
        return response()->json([
            'message' => 'Cantidad actualizada con exito!'
        ]);
    }

    public function acceptRequest(Request $request, Bodega $bodega)
    {
        $Prestador_id = $request->sedeselected;
        foreach ($request->articuloSelected as $request) {
            $orden = Ordencompra::find($request['id']);

            $orden->update([
                'Cantidad' => $request['Cantidad'],
                'Estado_id' => 7,
                'Usuarioresponde_id' => auth()->user()->id,
                'Prestador_id' => $Prestador_id
            ]);
        }

        return response()->json([
            'message' => 'Solicitud de compras aceptadas!'
        ],200);
    }

    public function deshabilitarOrden(Request $request, Ordencompra $ordencompra)
    {
        $ordencompra->update([
            'Estado_id' => 6
        ]);
        return response()->json([
            'message' => 'Orden de compra deshabilitada con exito!'
        ]);
    }
}
