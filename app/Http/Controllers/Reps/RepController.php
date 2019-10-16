<?php

namespace App\Http\Controllers\Reps;

use App\Modelos\Rep;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RepController extends Controller
{

    public function all()
    {
        $rep = Rep::all();
        return response()->json($rep, 200);
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, Rep $rep)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modelos\Rep  $rep
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rep $rep)
    {
        //
    }
}
