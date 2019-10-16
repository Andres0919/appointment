<?php

namespace App\Http\Controllers\Historia;

use App\Modelos\Ginecologico;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\citapaciente;

class GinecologicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    
    public function store(Request $request, citapaciente $citapaciente)
    {
        // return $request->all();
        Ginecologico::create([
            'Citapaciente_id' => $citapaciente->id,
            'Fechaultimamenstruacion'       => $request->Fechaultimamenstruacion,
            'Gestaciones'                   => $request->Gestaciones,
            'Partos'                        => $request->Partos,
            'Abortoprovocado'               => $request->Abortoprovocado,
            'Abortoespontaneo'              => $request->Abortoespontaneo,
            'Mortinato'                     => $request->Mortinato,
            'Gestantefechaparto'            => $request->Gestantefechaparto,
            'Gestantenumeroctrlprenatal'    => $request->Gestantenumeroctrlprenatal,
            'Eutoxico'                      => $request->Eutoxico,
            'Cesaria'                       => $request->Cesaria,
            'Cancercuellouterino'           => $request->Cancercuellouterino,
            'Ultimacitologia'               => $request->Ultimacitologia,
            'Resultado'                     => $request->Resultado,
            'Menarquia'                     => $request->Menarquia,
            'Ciclos'                        => $request->Ciclos,
            'Regulares'                     => $request->Regulares,
            'Observaciongineco'             => $request->Observaciongineco,
        ]);

        return response()->json(['message' => 'sds!'], 201);
    }

    public function getGineco(citapaciente $citapaciente){

        $ginecologico = Ginecologico::select(
            'Fechaultimamenstruacion',
            'Gestaciones',
            'Partos',
            'Abortoprovocado',
            'Abortoespontaneo',
            'Mortinato',
            'Gestantefechaparto',
            'Gestantenumeroctrlprenatal',
            'Eutoxico',
            'Cesaria',
            'Cancercuellouterino',
            'Ultimacitologia',
            'Resultado',
            'Menarquia',
            'Ciclos',
            'Regulares',
            'Observaciongineco')
        ->where('Citapaciente_id', $citapaciente->id)
        ->first();

        return response()->json($ginecologico, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modelos\Ginecologico  $ginecologico
     * @return \Illuminate\Http\Response
     */
    public function show(Ginecologico $ginecologico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modelos\Ginecologico  $ginecologico
     * @return \Illuminate\Http\Response
     */
    public function edit(Ginecologico $ginecologico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modelos\Ginecologico  $ginecologico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ginecologico $ginecologico)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modelos\Ginecologico  $ginecologico
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ginecologico $ginecologico)
    {
        //
    }
}
