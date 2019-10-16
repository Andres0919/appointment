<?php

namespace App\Http\Controllers\Historia;

use App\Modelos\Incapacidade;
use App\Modelos\citapaciente;
use App\Modelos\Detaarticulorden;
use App\Modelos\Codesumi;
use App\Modelos\Orden;
use App\Modelos\Cup;
use App\Modelos\Cuporden;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrdenController extends Controller
{
    public function index()
    {
        //
    }

    public function ordenesMedicamento(Request $request)
    {
        $ordenes = Orden::select(['ordens.*','to.Nombre as tipo_orden'])
                ->join('cita_paciente as cp', 'ordens.Cita_id', 'cp.id')
                ->join('pacientes as p', 'cp.Paciente_id', 'p.id')
                ->join('tipordens as to', 'to.id', 'ordens.Tiporden_id')
                ->join('detaarticulordens as do', 'do.Orden_id', 'ordens.id')
                ->with(['detaarticulordens' => function ($query) {
                    $query->select('detaarticulordens.*', 'cs.Codigo as Codigo', 'cs.Nombre as medicamento')
                            ->join('codesumis as cs', 'detaarticulordens.Codesumi_id', 'cs.id')
                            ->whereIn('detaarticulordens.Estado_id', [1, 7, 18,19])
                            ->get();
                }])
                ->whereHas('detaarticulordens', function ($query) {
                    $query->whereIn('Estado_id', [1, 7, 18,19]);
                })
                ->distinct()
                ->where('p.Num_Doc', $request->Num_Doc)
                ->get();

        return response()->json($ordenes, 201);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lotesMedicamentos(Request $request)
    {
        $codesumi = Codesumi::select(['da.CUM_completo','da.Titular','l.*'])
                                ->join('detallearticulos as da', 'da.Codesumi_id', 'codesumis.id')
                                ->join('bodegarticulos as ba', 'ba.Detallearticulo_id', 'da.id')
                                ->join('bodegas as b', 'ba.Bodega_id', 'b.id')
                                ->join('lotes as l', 'l.Bodegarticulo_id', 'ba.id')
                                ->where('codesumis.id', $request->Codesumi_id)
                                ->where('b.id', $request->Bodega_id)
                                ->get();

        return response()->json($codesumi, 201);
    }


    private function getNivelOrdenamiento($rolesUser)
    {
        $nivel0 = [
            'Auxiliar de Enfermeria',
            'Auxiliar Sede Tipo D',
            'Nutricion',
            'Psicologia',
            'Fisioterapia',
            'Optometria',
            'Terapia Respiratoria',
            'Fonoaudiologia',
            'Neuropsicologia',
            'Trabajo Social',
            'Linea de frente',
        ];
        $nivel1 = [
            'Medicina General', 
            'Medicina Alternativa',
            'Odontologia',
            'Enfermeria',
            'Medicina Laboral'
        ];
        $nivel2 = [
            'Medico Experto RCCVM',
            'Medico Experto Salud Mental',
            'Medico Experto Reumatologia',
            'Medico Experto Anticoagulados',
            'Medico Experto Nefroproteccion',
            'Medico Experto Respiratorios',
            'Medico Experto Trasmisibles Cronicas',
            'Psiquiatria',
            'Ginecologia',
            'Obstetricia',
            'Medicina Interna',
            'Otorrinolaringologia',
            'Oftalmologia',
            'Ortopedia y Traumatologia',
            'Cirugia General',
            'Pediatria',
            'Dermatologia',
            'Medicina del Deporte',
            'Toxicologia',
            'Fisiatria',
            'Urologia',
            'Especialidades de Odontologia',
            'Lider de Sede'
        ];
        $nivel3 = [
            'Neurologia',
            'Cardiologia',
            'Anestesiologia',
            'Medicina Familiar',
            'Hematologia',
            'Nefrologia',
            'Endocrinologia',
            'Cirugia Coloproctologica',
            'Alergologia',
            'Mastologia',
            'Neumologia',
            'Medicina del Dolor',
            'Oncologia',
            'Neurocirugia',
            'Infectologia',
            'Reumatologia',
            'Electrofisiologia',
            'Gestion de Solicitudes',
            'Gestion de Solicitudes Odontologia'
        ];
        $nivel4 = [
            'Tutelas',
            'Coordinador Gestión de Solicitudes'
        ];

        foreach ($nivel4 as $nivel) {
            if (in_array($nivel, $rolesUser)) {
                return 4;
            }
        }
        foreach ($nivel3 as $nivel) {
            if (in_array($nivel, $rolesUser)) {
                return 3;
            }
        }
        foreach ($nivel2 as $nivel) {
            if (in_array($nivel, $rolesUser)) {
                return 2;
            }
        }
        foreach ($nivel1 as $nivel) {
            if (in_array($nivel, $rolesUser)) {
                return 1;
            }
        }

        return 0;
    }

    public function store(citapaciente $citapaciente, Request $request)
    {
        $ubicaciones = [];
        $rolesUser = auth()->user()->getRoleNames()->toArray();
        $niveluser = $this->getNivelOrdenamiento($rolesUser);

        $orden_return = '';
        switch ($request->Tiporden_id) {
            case 1:
                $date = date("Y-m-d");

                $incapacidad = $this->getRange($request);

                if (!empty($incapacidad)) {
                    return response()->json([
                        'message' => 
                        'Ya existe una incapacidad activa con fecha de inicio '.$incapacidad->Fechainicio.' y fecha final '.$incapacidad->Fechafinal
                    ], 404);
                }

                $orden = Orden::create([
                        'Tiporden_id' => $request->Tiporden_id,
                        'Cita_id' => $citapaciente->id,
                        'Usuario_id' => auth()->user()->id,
                        'paginacion' => '1',
                        'Estado_id' => 1,
                        'Fechaorden' => $date
                    ]);
                Incapacidade::create([
                    'Orden_id' => $orden->id,
                    'Fechainicio' => $request->Fechainicio,
                    'Dias' => $request->Dias,
                    'Fechafinal' => $request->Fechafinal,
                    'Prorroga' => $request->Prorroga,
                    'Cie10_id' => $request->Cie10_id,
                    'Contingencia' => $request->Contingencia,
                    'Descripcion' => $request->Descripcion,
                    'Usuarioordena_id' => auth()->user()->id,
                    'Usuarioedit_id' => auth()->user()->id,
                    'Laboraen' => $request->Laboraen,
                ]);
                break;
            case 3:
                $numOrdenes = [];
                foreach ($request->articulos as $articulo) {
                    for ($i=0; $i < $articulo['NumMeses']; $i++) {
                        if (!isset($numOrdenes[$i])) {
                            array_push($numOrdenes, []);
                        }
                        array_push($numOrdenes[$i], $articulo);
                    }
                }
                for ($i=0; $i < count($numOrdenes) ; $i++) {
                    $pagina = $i + 1;
                    $date = date('Y-m-d',strtotime("+".$i." month"));

                    $orden = Orden::where('Tiporden_id',$request->Tiporden_id)->where('Cita_id', $citapaciente->id)->where('paginacion','like',$pagina.'/%')->first();
                    if(!isset($orden)){
                        $orden = Orden::create([
                            'Tiporden_id' => $request->Tiporden_id,
                            'Cita_id' => $citapaciente->id,
                            'Usuario_id' => auth()->user()->id,
                            'paginacion' => $pagina.'/'.count($numOrdenes),
                            'Estado_id' => 1,
                            'Fechaorden' => $date
                        ]);
                    }else{
                        $countNumOrdenes = count($numOrdenes);
                        $paginacionLastOrden = explode("/", $orden->paginacion);

                        if(intval($paginacionLastOrden[1]) > $countNumOrdenes){
                            $countNumOrdenes = $paginacionLastOrden[1];
                        }
                        
                        $orden->update([
                            'Usuario_id' => auth()->user()->id,
                            'paginacion' => $pagina.'/'.$countNumOrdenes,
                            'Estado_id' => 1,
                            'Fechaorden' => $date
                        ]);
                    }

                    if ($i == 0) {
                        $orden_return = $orden->id;
                    }

                    for ($j=0; $j < count($numOrdenes[$i]) ; $j++) {
                        $codigo = Codesumi::find($numOrdenes[$i][$j]['id']);
                        $estado = 1;
                        if ($codigo->Requiere_autorizacion == 'SI' || ($niveluser < $codigo->Nivel_Ordenamiento)) {
                            $estado = 15;
                        }
                        Detaarticulorden::create([
                            'Orden_id' => $orden->id,
                            'codesumi_id' => $numOrdenes[$i][$j]['id'],
                            'Estado_id' => $estado,
                            'Cantidadosis' => $numOrdenes[$i][$j]['Cantidadosis'],
                            'Via' => $numOrdenes[$i][$j]['Via'],
                            'Unidadmedida' => $numOrdenes[$i][$j]['Unidadmedida'],
                            'Frecuencia' => $numOrdenes[$i][$j]['Frecuencia'],
                            'Unidadtiempo' => $numOrdenes[$i][$j]['Unidadtiempo'],
                            'Duracion' => $numOrdenes[$i][$j]['Duracion'],
                            'Cantidadmensual' => $numOrdenes[$i][$j]['Cantidadmensual'],
                            'Cantidadmensualdisponible' => $numOrdenes[$i][$j]['Cantidadpormedico'],
                            'Cantidadpormedico' => $numOrdenes[$i][$j]['Cantidadpormedico'],
                            'NumMeses' => $numOrdenes[$i][$j]['NumMeses'],
                            'Observacion' => $numOrdenes[$i][$j]['Observacion'],
                            'Fechaorden' => $date
                        ]);
                    }
                }
                break;
            case 2:
            case 4:
                $numOrdenes = [];
                $date = date("Y-m-d h:i:s");
                $orden = Orden::where('Tiporden_id',$request->Tiporden_id)->where('Cita_id', $citapaciente->id)->first();
                if(!isset($orden)){
                    $orden = Orden::create([
                        'Tiporden_id' => $request->Tiporden_id,
                        'Cita_id' => $citapaciente->id,
                        'Usuario_id' => auth()->user()->id,
                        'Estado_id' => 1,
                        'Fechaorden' => $date
                    ]);
                }
                
                foreach ($request->procedimientos as $procedimiento) {

                    $cup = Cup::find($procedimiento['id']);
                    $estado = 1;
                    if ($cup->Requiere_auditoria == 'SI' || ($niveluser < $cup->Nivelordenamiento)) {
                        $estado = 15;
                    }
                    Cuporden::create([
                        'Orden_id' => $orden->id,
                        'Cup_id' => $procedimiento['id'],
                        'Cantidad' => $procedimiento['cantidad'],
                        'Observacionorden' => $procedimiento['observacion'],
                        'Estado_id' => $estado,
                    ]);
                }

                $direcciones = DB::select("exec dbo.cupsdireccionamiento". "'$orden->id'");

                foreach ($direcciones as $direccion) {
                    $cuporden = Cuporden::where('Cup_id', $direccion->tarifacup_id)->where('Orden_id', $orden->id)->first();

                    $cuporden->update([
                        'Ubicacion_id' => $direccion->sedeproveedor_id,
                        'valor_tarifa' => $direccion->valor_tarifa,
                        'valor_total' => $direccion->valor_total,
                        'valor_transporte' => $direccion->valor_transporte,
                    ]);

                }
                break;
            
            default:
                return response()->json([
                    'message' => 'Tipo de orden no existe'
                ], 404);
                break;
        }

        return response()->json([
            'orden_id' => $orden->id,
            'message' => 'Orden generada',
        ], 201);
    }

    public function getOrdeninCupOrden(Orden $orden){
        $cuporden = Cuporden::where('Orden_id', $orden->id)->get();

        return response()->json($cuporden, 201);
    }

    public function getOrdeninDetaArticuloOrden(Orden $orden){
        $detaarticuloorden = Detaarticulorden::where('Orden_id', $orden->id)->get();

        return response()->json($detaarticuloorden, 201);
    }

    public function getOrderById(citapaciente $citapaciente, Request $request){
        $orden = Orden::where('Cita_id', $citapaciente->id)->where('Tiporden_id', $request->Tiporden_id)->first();

        return response()->json($orden, 201);
    }

    public function getOrderedCups(citapaciente $citapaciente, Request $request){

        $ordereds = Orden::select(['co.id','co.Orden_id','co.Observacionorden as observacion','co.Estado_id', 'co.Cantidad as cantidad', 'co.Ubicacion_id', 'c.Codigo as codigo','c.Nombre as nombre','sp.Nombre as ubicacion', 'sp.Direccion as direccion', 'sp.Telefono1 as telefono', 'e.Nombre as estado', 'c.id as cup_id'])
                        ->join('cupordens as co', 'co.Orden_id','ordens.id')
                        ->join('estados as e', 'co.Estado_id','e.id')
                        ->join('cups as c', 'co.Cup_id','c.id')
                        ->leftJoin('sedeproveedores as sp', 'co.Ubicacion_id','sp.id')
                        ->where('ordens.Cita_id', $citapaciente->id)
                        ->where('ordens.Tiporden_id', $request->Tiporden_id)
                        ->get();

        return response()->json($ordereds, 200);
    }

    public function getOrderedCodesumi(citapaciente $citapaciente){

        $ordereds = Orden::select(['ordens.*'])
                        ->join('detaarticulordens as da', 'da.Orden_id','ordens.id')
                        ->with(['detaarticulordens' => function($query){
                            $query->select('detaarticulordens.*','e.Nombre as estado','c.Nombre as nombre','c.Codigo')
                                    ->join('estados as e', 'detaarticulordens.Estado_id','e.id')
                                    ->join('codesumis as c', 'detaarticulordens.codesumi_id','c.id');
                        }])
                        ->where('Cita_id', $citapaciente->id)
                        ->distinct()
                        ->first();

        return response()->json($ordereds, 200);
    }

    public function getOrderedCie(citapaciente $citapaciente){
        $incapacidades = Incapacidade::select(['incapacidades.*'])
                        ->join('ordens as o','incapacidades.Orden_id','o.id')
                        ->where('o.Cita_id',$citapaciente->id)
                        ->get();

        return response()->json($incapacidades, 200);
    }

    private function getRange($request)
    {
        $incapacidades = Incapacidade::select(['incapacidades.*'])
                        ->join('ordens as o','incapacidades.Orden_id','o.id')
                        ->join('cita_paciente as c','o.Cita_id','c.id')
                        ->join('pacientes as p','c.Paciente_id','p.id')
                        ->where('p.Num_Doc', $request->Cedula)
                        ->where('incapacidades.Estado_id', 1)
                        ->whereBetween('incapacidades.Fechainicio', [$request->Fechainicio, $request->Fechafinal])
                        ->orWhereBetween('incapacidades.Fechafinal', [$request->Fechainicio, $request->Fechafinal])
                        ->first();

        return $incapacidades;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Display the specified resource.
     *
     * @param  \App\Modelos\Ordens  $ordens
     * @return \Illuminate\Http\Response
     */
    public function show(Ordens $ordens)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modelos\Ordens  $ordens
     * @return \Illuminate\Http\Response
     */
    public function edit(Ordens $ordens)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modelos\Ordens  $ordens
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ordens $ordens)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modelos\Ordens  $ordens
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ordens $ordens)
    {
        //
    }
}
