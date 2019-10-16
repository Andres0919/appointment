<?php

namespace App\Http\Controllers\Bodegas;

use App\Modelos\Bodega;
use App\Modelos\Codesumi;
use App\Modelos\Articulo;
use Illuminate\Http\Request;
use App\Modelos\bodegarticulo;
use App\Modelos\Detallearticulo;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BodegarticuloController extends Controller
{
    
    public function inventariobodega(Request $request){
        $inventariobodega = DB::select("exec dbo.InventarioBodega". " $request->Bodega_id");
        return response()->json($inventariobodega, 200);
    }

    public function all(Bodega $bodega, Request $request)
    {
        //
        $codesumis = Codesumi::select(['codesumis.*'])
                    ->join('detallearticulos as da','da.Codesumi_id','codesumis.id')
                    ->join('bodegarticulos as ba','ba.Detallearticulo_id','da.id')
                    ->with(['detallearticulos' => function($query) use ($bodega){
                        $query->select('detallearticulos.id','detallearticulos.Codesumi_id','detallearticulos.CUM_completo','detallearticulos.Titular','ba.id as Bodegarticulo_id')
                                ->join('bodegarticulos as ba','ba.Detallearticulo_id','detallearticulos.id')
                                ->where('ba.Bodega_id', $bodega->id)
                                ->get();
                    }])
                    ->whereHas('detallearticulos',function ($query) use ($bodega){
                        $query->where('Estado_id', 1);
                    })
                    ->whereNotNull('codesumis.Codigo')
                    ->whereNotNull('codesumis.Frecuencia')
                    ->whereNotNull('codesumis.Cantidadmaxordenar')
                    ->whereNotNull('codesumis.Requiere_autorizacion')
                    ->whereNotNull('codesumis.Nivel_Ordenamiento')
                    // ->where('da.Activo_HORUS','SI')
                    ->where('ba.Bodega_id', $bodega->id)
                    ->where('codesumis.Nombre', 'LIKE', '%'.$request->nombre.'%')
                    ->where('codesumis.Estado_id',1)->get();
        return response()->json($codesumis, 200);
    }

    public function allArticulos(Bodega $bodega, Request $request)
    {
        $codesumis = Codesumi::select(['codesumis.','da.'])
                    ->join('detallearticulos as da','da.Codesumi_id','codesumis.id')
                    ->join('bodegarticulos as ba','ba.Detallearticulo_id','da.id')
                    ->whereNotNull('codesumis.Codigo')
                    ->whereNotNull('codesumis.Frecuencia')
                    ->whereNotNull('codesumis.Cantidadmaxordenar')
                    ->whereNotNull('codesumis.Requiere_autorizacion')
                    ->whereNotNull('codesumis.Nivel_Ordenamiento')
                    ->where('da.Activo_HORUS','SI')
                    ->where('ba.Bodega_id', $bodega->id)
                    ->where('codesumis.Nombre', 'LIKE', '%'.$request->nombre.'%')
                    ->where('codesumis.Estado_id',1)
                    ->distinct()
                    ->count();
        return response()->json($codesumis, 200);
    }

    public function store(Request $request)
    {
        //
        $input = $request->all();
        bodegarticulo::create($input);
        return response()->json([
            'message' => 'Bodegarticulo fue creado con exito!'
        ], 201);
    }

    public function update(Request $request, Bodegarticulo $bodega, Detallearticulo $detallearticulo)
    {
        $bodega->update([
            'Stock' => $request->Stock,
            'Cantidadmaxima' => $request->Cantidadmaxima,
            'Cantidadminima' => $request->Cantidadminima,

        ]);
        return response()->json([
            'message' => 'Bodegarticulo actualizado con exito!'
        ]);
    }
}