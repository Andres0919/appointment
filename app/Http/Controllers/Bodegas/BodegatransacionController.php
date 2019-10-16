<?php

namespace App\Http\Controllers\Bodegas;

use App\Modelos\Tipo;
use App\Modelos\Bodega;
use App\Modelos\Movimiento;
use App\Modelos\Municipio;
use App\Modelos\Transacion;
use App\Modelos\Tipotransacion;
use App\Modelos\Bodegatransacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BodegatransacionController extends Controller
{
    public function all()
    {
        $bodegatransacion = Bodegatransacion::select(['Bodegatransacions.*', 'Transacions.Nombre as NombreTransacion', 'Tipos.Nombre as NombreTipo',
                                                      'Bodegas.Nombre as NombreBodega', 'Municipios.nombre as NombreMunicipio', 'Departamentos.nombre as NombreDepartamento',
                                                      'Articulos.Principioactivo', 'Tipobodegas.Nombre as NomTipoBodega'])
        ->join('Bodegarticulos', 'Bodegatransacions.Bodegarticulo_id', 'Bodegarticulo.id')
        ->join('Movimientos', 'Bodegatransacions.Transacion_id', 'Movimientos.id')
        ->join('Tipotransacions', 'Movimientos.Tipotransacion_id', 'Tipotransacions.id')
        ->join('Transacions', 'Tipotransacions.Transacion_id', 'Transacions.id')
        ->join('Tipos', 'Tipotransacions.Tipo_id', 'Tipo.id')
        ->join('Movimientos', 'Movimientos.Bodega_id', 'Bodegas.id')
        ->join('Municipios', 'Bodegas.Municipio_id', 'Municipios.id')
        ->join('Departamentos', 'Municipios.Departamento_id', 'Departamentos.id')
        ->join('Detallearticulos', 'Bodegarticulos.Detallearticulo_id', 'Detallearticulos.id')
        ->join('Articulos', 'Detallearticulos.Articulo_id', 'Articulos.id')
        ->join('Tipobodegas', 'Bodegas.Tipobodega_id', 'Tipobodegas.id')
        ->where('Tipobodegas.Estado', 3)
        ->where('Tipos.Estado', 1)
        ->where('Transacions.Estado', 1)
        ->where('Articulos.Estado', 1)
        ->where('Bodegatransacions.Estado', 1)
        ->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modelos\Bodegatransacion  $bodegatransacion
     * @return \Illuminate\Http\Response
     */
    public function show(Bodegatransacion $bodegatransacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modelos\Bodegatransacion  $bodegatransacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Bodegatransacion $bodegatransacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modelos\Bodegatransacion  $bodegatransacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bodegatransacion $bodegatransacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modelos\Bodegatransacion  $bodegatransacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bodegatransacion $bodegatransacion)
    {
        //
    }
}
