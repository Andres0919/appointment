<?php

namespace App\Http\Controllers\Historia;

use App\Modelos\Tiporden;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TipordenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        //
        $tipos = Tiporden::where('Estado_id', 1)->get();

        return response()->json($tipos, 200);
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
     * @param  \App\Modelos\Tiporden  $tiporden
     * @return \Illuminate\Http\Response
     */
    public function show(Tiporden $tiporden)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modelos\Tiporden  $tiporden
     * @return \Illuminate\Http\Response
     */
    public function edit(Tiporden $tiporden)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modelos\Tiporden  $tiporden
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tiporden $tiporden)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modelos\Tiporden  $tiporden
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tiporden $tiporden)
    {
        //
    }
}
