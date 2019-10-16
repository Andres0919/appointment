<?php

namespace App\Http\Controllers\Tarifarios;

use App\Modelos\Valormanual;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ValormanualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $valormanual = Valormanual::all();
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
     * @param  \App\Modelos\Valormanual  $valormanual
     * @return \Illuminate\Http\Response
     */
    public function show(Valormanual $valormanual)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modelos\Valormanual  $valormanual
     * @return \Illuminate\Http\Response
     */
    public function edit(Valormanual $valormanual)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modelos\Valormanual  $valormanual
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Valormanual $valormanual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modelos\Valormanual  $valormanual
     * @return \Illuminate\Http\Response
     */
    public function destroy(Valormanual $valormanual)
    {
        //
    }
}
