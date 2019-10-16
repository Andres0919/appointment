<?php

namespace App\Http\Controllers\Historia;

use App\Modelos\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ResumenhistoriaController extends Controller
{
    public function gethistoria(Request $request){
        $historia = DB::select("exec dbo.GeneraHC". "'$request->Num_Doc'");
        return response()->json($historia, 200);
    }
}
