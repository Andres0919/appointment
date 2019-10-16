<?php

namespace App\Http\Controllers\Historia;

use App\Modelos\Autorizacion;
use App\Modelos\Auditoria;
use App\Modelos\Orden;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Detaarticulorden;
use App\Modelos\Sedeproveedore;
use App\Modelos\Cuporden;
use App\User;

class AutorizacionController extends Controller
{
    public function listaAutorizacionesMedicamentos(Request $request)
    {
        $ordereds = Orden::select([
            'ordens.*',
            'user.name as User_Name',
            'user.apellido as User_LastName',
            'user.Firma as Medico_Firma',
            'cita_paciente.id as citaPaciente_id',
            'p.Departamento',
            'p.created_at as paciente_created',
            'p.Primer_Nom as Primer_Nom',
            'p.SegundoNom as Segundo_Nom',
            'p.Primer_Ape as Primer_Ape',
            'p.Segundo_Ape as Segundo_Ape',
            'p.Tipo_Doc as Tipo_Doc',
            'p.Num_Doc as Cedula',
            'p.Edad_Cumplida as Edad_Cumplida',
            'p.Sexo as Sexo',
            'p.IPS as IpsAtencion',
            'p.Direccion_Residencia as Direccion_Residencia',
            'p.Correo1 as Correo',
            'p.Telefono as Telefono',
            'p.Celular1 as Celular',
            'p.Tipo_Afiliado as Tipo_Afiliado',
            'p.Estado_Afiliado as Estado_Afiliado',
            'm.Nombre as Municipio',
            's.Nombre as Nombre_IPS',
            's.Direccion as Direccion_IPS',
            's.Telefono1 as Telefono_IPS',
            'cie10.Codigo_CIE10 as Codigo_CIE10',
            'cie10.Descripcion as Descripcion_CIE10'])
        ->join('detaarticulordens as da', 'ordens.id', 'da.Orden_id')
        ->join('Users as user', 'ordens.Usuario_id', 'user.id')
        ->join('cita_paciente as cita_paciente', 'ordens.Cita_id', 'cita_paciente.id')
        ->join('Pacientes as p', 'cita_paciente.Paciente_id', 'p.id')
        ->join('Municipios as m', 'p.Mpio_Atencion', 'm.id')
        ->leftJoin('sedeproveedores as s', 'p.IPS', 's.id')
        ->leftJoin('cie10pacientes as cie10p', 'cie10p.Citapaciente_id', 'cita_paciente.id')
        ->leftJoin('cie10s as cie10', 'cie10.id', 'cie10p.Cie10_id')
        ->with(['detaarticulordens' => function ($query) use ($request) {
            $query->select(
                'detaarticulordens.id as id',
                'detaarticulordens.created_at as FechaSolicitud',
                'detaarticulordens.Cantidadosis as Cantidad_Dosis',
                'detaarticulordens.codesumi_id as Codesumi_id',
                'detaarticulordens.Via as Via',
                'detaarticulordens.Unidadmedida as Unidad_Medida',
                'detaarticulordens.Frecuencia as Frecuencia',
                'detaarticulordens.Unidadtiempo as Unidad_Tiempo',
                'detaarticulordens.Duracion as Duracion',
                'detaarticulordens.Cantidadmensual as Cantidad_Mensual',
                'detaarticulordens.Nummeses as Num_Meses',
                'detaarticulordens.Observacion as Observacion',
                'detaarticulordens.Cantidadpormedico as Cantidad_Medico',
                'detaarticulordens.Orden_id as Orden_id',
                'detaarticulordens.Fechaorden as Fecha_Orden',
                'detaarticulordens.Estado_id as Estado_id',
                'c.Nombre as Nombre',
                'c.Codigo as Codigo',
                'c.Requiere_autorizacion as Requiere_Autorizacion'
            )
                    ->join('codesumis as c', 'detaarticulordens.codesumi_id', 'c.id')
                    ->where('detaarticulordens.Estado_id', 15)
                    ->whereMonth('detaarticulordens.Fechaorden', '=', $request->month)
                    ->get();
        }])
        ->where('da.Estado_id', 15)
        ->whereMonth('da.Fechaorden', '=', $request->month)
        // ->where('cie10p.Esprimario', true)
        ->distinct()
        ->get();
        
        return response()->json($ordereds, 200);
    }

    public function listAuthMedicByState(Request $request)
    {
        // $detaarticulorden = Detaarticulorden::select(
        //     'Detaarticulordens.id as id',
        //     'Detaarticulordens.created_at as FechaSolicitud',
        //     'Detaarticulordens.Cantidadosis as Cantidad_Dosis',
        //     'Detaarticulordens.codesumi_id as Codesumi_id',
        //     'Detaarticulordens.Via as Via',
        //     'Detaarticulordens.Unidadmedida as Unidad_Medida',
        //     'Detaarticulordens.Frecuencia as Frecuencia',
        //     'Detaarticulordens.Unidadtiempo as Unidad_Tiempo',
        //     'Detaarticulordens.Duracion as Duracion',
        //     'Detaarticulordens.Cantidadmensual as Cantidad_Mensual',
        //     'Detaarticulordens.Nummeses as Num_Meses',
        //     'Detaarticulordens.Observacion as Observacion',
        //     'Detaarticulordens.Cantidadpormedico as Cantidad_Medico',
        //     'Detaarticulordens.Orden_id as Orden_id',
        //     'Detaarticulordens.Fechaorden as Fecha_Orden',
        //     'Detaarticulordens.Estado_id as Estado_id',
        //     'Users.name as User_Name',
        //     'Users.apellido as User_LastName',
        //     'Pacientes.Departamento',
        //     'Pacientes.created_at',
        //     'Pacientes.Primer_Nom as Primer_Nom',
        //     'Pacientes.SegundoNom as Segundo_Nom',
        //     'Pacientes.Primer_Ape as Primer_Ape',
        //     'Pacientes.Segundo_Ape as Segundo_Ape',
        //     'Pacientes.Tipo_Doc as Tipo_Doc',
        //     'Pacientes.Num_Doc as Cedula',
        //     'Pacientes.Edad_Cumplida as Edad_Cumplida',
        //     'Pacientes.Sexo as Sexo',
        //     'Pacientes.IPS as IpsAtencion',
        //     'Pacientes.Direccion_Residencia as Direccion_Residencia',
        //     'Pacientes.Correo1 as Correo',
        //     'Pacientes.Telefono as Telefono',
        //     'Pacientes.Tipo_Afiliado as Tipo_Afiliado',
        //     'Pacientes.Estado_Afiliado as Estado_Afiliado',
        //     'Municipios.Nombre as Municipio',
        //     'cita_paciente.id as citaPaciente_id',
        //     'codesumis.Nombre as Nombre',
        //     'codesumis.Codigo as Codigo',
        //     'codesumis.Requiere_autorizacion as Requiere_Autorizacion',
        //     'sedeproveedores.Nombre as Nombre_IPS',
        //     'sedeproveedores.Direccion as Direccion_IPS',
        //     'sedeproveedores.Telefono1 as Telefono_IPS',
        //     'cie10s.Codigo_CIE10 as Codigo_CIE10',
        //     'cie10s.Descripcion as Descripcion_CIE10',
        //     'autorizacions.Nota as Auth_Nota',
        //     'autorizacions.updated_at as FechaAutorizacion'
        // )
        //         ->join('Ordens', 'Detaarticulordens.Orden_id', 'Ordens.id')
        //         ->leftJoin('autorizacions', 'Detaarticulordens.id', 'autorizacions.Articulorden_id')
        //         ->join('Users', 'Ordens.Usuario_id', 'Users.id')
        //         ->join('cita_paciente', 'Ordens.Cita_id', 'cita_paciente.id')
        //         ->join('Pacientes', 'cita_paciente.Paciente_id', 'Pacientes.id')
        //         ->join('Municipios', 'Pacientes.Mpio_Atencion', 'Municipios.id')
        //         ->leftJoin('sedeproveedores', 'Pacientes.IPS', 'sedeproveedores.id')
        //         ->join('codesumis', 'Detaarticulordens.Codesumi_id', 'codesumis.id')
        //         ->leftJoin('cie10pacientes', 'cie10pacientes.Citapaciente_id', 'cita_paciente.id')
        //         ->leftJoin('cie10s', 'cie10s.id', 'cie10pacientes.Cie10_id')
        //         ->where('Detaarticulordens.Estado_id', $request->status)
        //         ->where(function ($query) use ($request) {
        //             $query->whereBetween('Detaarticulordens.Fechaorden', [$request->fechaStart, $request->fechaEnd])
        //                   ->orWhere('Pacientes.Num_Doc', $request->cedula);
        //         })
        //         ->get();

        $ordereds = Orden::select([
            'ordens.*',
            'user.name as User_Name',
            'user.apellido as User_LastName',
            'user.Firma as Medico_Firma',
            'cita_paciente.id as citaPaciente_id',
            'p.Departamento',
            'p.created_at as paciente_created',
            'p.Primer_Nom as Primer_Nom',
            'p.SegundoNom as Segundo_Nom',
            'p.Primer_Ape as Primer_Ape',
            'p.Segundo_Ape as Segundo_Ape',
            'p.Tipo_Doc as Tipo_Doc',
            'p.Num_Doc as Cedula',
            'p.Edad_Cumplida as Edad_Cumplida',
            'p.Sexo as Sexo',
            'p.IPS as IpsAtencion',
            'p.Direccion_Residencia as Direccion_Residencia',
            'p.Correo1 as Correo',
            'p.Telefono as Telefono',
            'p.Celular1 as Celular',
            'p.Tipo_Afiliado as Tipo_Afiliado',
            'p.Estado_Afiliado as Estado_Afiliado',
            'm.Nombre as Municipio',
            's.Nombre as Nombre_IPS',
            's.Direccion as Direccion_IPS',
            's.Telefono1 as Telefono_IPS',
            'cie10.Codigo_CIE10 as Codigo_CIE10',
            'cie10.Descripcion as Descripcion_CIE10'])
        ->join('detaarticulordens as da', 'ordens.id', 'da.Orden_id')
        ->join('Users as user', 'ordens.Usuario_id', 'user.id')
        ->join('cita_paciente as cita_paciente', 'ordens.Cita_id', 'cita_paciente.id')
        ->join('Pacientes as p', 'cita_paciente.Paciente_id', 'p.id')
        ->join('Municipios as m', 'p.Mpio_Atencion', 'm.id')
        ->leftJoin('sedeproveedores as s', 'p.IPS', 's.id')
        ->leftJoin('cie10pacientes as cie10p', 'cie10p.Citapaciente_id', 'cita_paciente.id')
        ->leftJoin('cie10s as cie10', 'cie10.id', 'cie10p.Cie10_id')
        ->with(['detaarticulordens' => function ($query) use ($request) {
            $query->select(
                'detaarticulordens.id as id',
                'detaarticulordens.created_at as FechaSolicitud',
                'detaarticulordens.Cantidadosis as Cantidad_Dosis',
                'detaarticulordens.codesumi_id as Codesumi_id',
                'detaarticulordens.Via as Via',
                'detaarticulordens.Unidadmedida as Unidad_Medida',
                'detaarticulordens.Frecuencia as Frecuencia',
                'detaarticulordens.Unidadtiempo as Unidad_Tiempo',
                'detaarticulordens.Duracion as Duracion',
                'detaarticulordens.Cantidadmensual as Cantidad_Mensual',
                'detaarticulordens.Nummeses as Num_Meses',
                'detaarticulordens.Observacion as Observacion',
                'detaarticulordens.Cantidadpormedico as Cantidad_Medico',
                'detaarticulordens.Orden_id as Orden_id',
                'detaarticulordens.Fechaorden as Fecha_Orden',
                'detaarticulordens.Estado_id as Estado_id',
                'c.Nombre as Nombre',
                'c.Codigo as Codigo',
                'c.Requiere_autorizacion as Requiere_Autorizacion',
                'a.Nota as Auth_Nota',
                'a.updated_at as FechaAutorizacion',
                'u.name as Auth_Name',
                'u.apellido as Auth_Apellido',
                'u.Firma as Auth_Firma'
            )
                    ->join('codesumis as c', 'detaarticulordens.codesumi_id', 'c.id')
                    ->leftJoin('autorizacions as a', 'detaarticulordens.id', 'a.Articulorden_id')
                    ->leftJoin('Users as u', 'a.Usuario_id', 'u.id')
                    ->where('detaarticulordens.Estado_id', $request->status)
                    ->get();
        }])
        ->where('da.Estado_id', $request->status)
        ->Where('p.Num_Doc', $request->cedula)
        // ->where('cie10p.Esprimario', true)
        ->distinct()
        ->get();

        // return response()->json($detaarticulorden, 200);

        return response()->json($ordereds, 200);
    }

    public function listaAutorizacionesServicios(Request $request)
    {
        $ordereds = Orden::select([
            'ordens.*',
            'user.name as User_Name',
            'user.apellido as User_LastName',
            'user.Firma as Medico_Firma',
            'cita_paciente.id as citaPaciente_id',
            'p.Departamento',
            'p.created_at as paciente_created',
            'p.Primer_Nom as Primer_Nom',
            'p.SegundoNom as Segundo_Nom',
            'p.Primer_Ape as Primer_Ape',
            'p.Segundo_Ape as Segundo_Ape',
            'p.Tipo_Doc as Tipo_Doc',
            'p.Num_Doc as Cedula',
            'p.Edad_Cumplida as Edad_Cumplida',
            'p.Sexo as Sexo',
            'p.IPS as IpsAtencion',
            'p.Direccion_Residencia as Direccion_Residencia',
            'p.Correo1 as Correo',
            'p.Telefono as Telefono',
            'p.Celular1 as Celular',
            'p.Tipo_Afiliado as Tipo_Afiliado',
            'p.Estado_Afiliado as Estado_Afiliado',
            'm.Nombre as Municipio',
            'sede_paciente.Nombre as Nombre_IPS',
            'cie10.Codigo_CIE10 as Codigo_CIE10',
            'cie10.Descripcion as Descripcion_CIE10'])
        ->join('Cupordens as co', 'ordens.id', 'co.Orden_id')
        ->join('Users as user', 'ordens.Usuario_id', 'user.id')
        ->join('cita_paciente as cita_paciente', 'ordens.Cita_id', 'cita_paciente.id')
        ->join('Pacientes as p', 'cita_paciente.Paciente_id', 'p.id')
        ->join('Municipios as m', 'p.Mpio_Atencion', 'm.id')
        ->leftJoin('sedeproveedores as sede_paciente', 'p.IPS', 'sede_paciente.id')
        ->leftJoin('cie10pacientes as cie10p', 'cie10p.Citapaciente_id', 'cita_paciente.id')
        ->leftJoin('cie10s as cie10', 'cie10.id', 'cie10p.Cie10_id')
        ->with(['cupordens' => function ($query) use ($request) {
            $query->select(
                'Cupordens.id as id',
                'Cupordens.created_at as FechaSolicitud',
                'Cupordens.Cup_id as Cup',
                'Cupordens.Cantidad as Cup_Cantidad',
                'Cupordens.Orden_id as Orden_id',
                'Cupordens.Observacionorden as observaciones',
                'Cupordens.Estado_id as Estado_id',
                'c.id as Cup_Id',
                'c.Nombre as Cup_Nombre',
                'c.Codigo as Cup_Codigo',
                's.id as Sede_Id',
                's.Nombre as Sede_Nombre',
                's.Direccion as Sede_Direccion',
                's.Telefono1 as Sede_Telefono',
            )
                    ->join('Cups as c', 'Cupordens.Cup_id', 'c.id')
                    ->leftJoin('sedeproveedores as s', 'Cupordens.Ubicacion_id', 's.id')
                    ->where('Cupordens.Estado_id', 15)
                    ->whereMonth('Cupordens.created_at', '=', $request->month)
                    ->get();
        }])
        ->where('co.Estado_id', 15)
        ->whereMonth('co.created_at', '=', $request->month)
        // ->where('cie10p.Esprimario', true)
        ->distinct()
        ->get();
        
        return response()->json($ordereds, 200);
    }

    public function listAuthServByState(Request $request)
    {
        // $cuporden = Cuporden::select(
        //     'Cupordens.id as id',
        //     'Cupordens.created_at as FechaSolicitud',
        //     'Cupordens.Cup_id as Cup',
        //     'Cupordens.Cantidad as Cup_Cantidad',
        //     'Cupordens.Orden_id as Orden_id',
        //     'Cupordens.Observacionorden as observaciones',
        //     'Cupordens.Estado_id as Estado_id',
        //     'Users.name as User_Name',
        //     'Users.apellido as User_LastName',
        //     'Pacientes.Departamento',
        //     'Pacientes.created_at',
        //     'Pacientes.Primer_Nom as Primer_Nom',
        //     'Pacientes.SegundoNom as Segundo_Nom',
        //     'Pacientes.Primer_Ape as Primer_Ape',
        //     'Pacientes.Segundo_Ape as Segundo_Ape',
        //     'Pacientes.Tipo_Doc as Tipo_Doc',
        //     'Pacientes.Num_Doc as Cedula',
        //     'Pacientes.Edad_Cumplida as Edad_Cumplida',
        //     'Pacientes.Sexo as Sexo',
        //     'Pacientes.IPS as IpsAtencion',
        //     'Pacientes.Direccion_Residencia as Direccion_Residencia',
        //     'Pacientes.Correo1 as Correo',
        //     'Pacientes.Telefono as Telefono',
        //     'Pacientes.Tipo_Afiliado as Tipo_Afiliado',
        //     'Pacientes.Estado_Afiliado as Estado_Afiliado',
        //     'Municipios.Nombre as Municipio',
        //     'Cups.id as Cup_Id',
        //     'Cups.Codigo as Cup_Codigo',
        //     'Cups.Nombre as Cup_Nombre',
        //     'Sedeproveedores.Nombre as Sede_Nombre',
        //     'sedeproveedores.Direccion as Sede_Direccion',
        //     'sedeproveedores.Telefono1 as Sede_Telefono',
        //     'sede_paciente.Nombre as Nombre_IPS',
        //     'cita_paciente.id as citaPaciente_id',
        //     'cie10s.Codigo_CIE10 as Codigo_CIE10',
        //     'cie10s.Descripcion as Descripcion_CIE10',
        //     'autorizacions.Nota as Auth_Nota',
        //     'autorizacions.updated_at as FechaAutorizacion'
        // )
        //         ->join('Ordens', 'Cupordens.Orden_id', 'Ordens.id')
        //         ->leftJoin('autorizacions', 'Cupordens.id', 'autorizacions.Cuporden_id')
        //         ->join('Users', 'Ordens.Usuario_id', 'Users.id')
        //         ->join('cita_paciente', 'Ordens.Cita_id', 'cita_paciente.id')
        //         ->join('Cups', 'Cups.id', 'Cupordens.Cup_id')
        //         ->join('Pacientes', 'cita_paciente.Paciente_id', 'Pacientes.id')
        //         ->join('Municipios', 'Pacientes.Mpio_Atencion', 'Municipios.id')
        //         ->leftJoin('cie10pacientes', 'cie10pacientes.Citapaciente_id', 'cita_paciente.id')
        //         ->leftJoin('cie10s', 'cie10s.id', 'cie10pacientes.Cie10_id')
        //         ->leftJoin('Sedeproveedores', 'Cupordens.Ubicacion_id', 'Sedeproveedores.id')
        //         ->leftJoin('Sedeproveedores as sede_paciente', 'Pacientes.IPS', 'sede_paciente.id')
        //         ->where('Cupordens.Estado_id', $request->status)
        //         ->where(function ($query) use ($request) {
        //             $query->whereBetween('Cupordens.created_at', [$request->fechaStart, $request->fechaEnd])
        //                   ->orWhere('Pacientes.Num_Doc', $request->cedula);
        //             // ->whereBetween('Cupordens.created_at', [$request->fechaStart, $request->fechaEnd])
        //         // ->where('Pacientes.Num_Doc', $request->cedula)
        //         })
        //         ->get();

        $ordereds = Orden::select([
            'ordens.*',
            'user.name as User_Name',
            'user.apellido as User_LastName',
            'user.Firma as Medico_Firma',
            'cita_paciente.id as citaPaciente_id',
            'p.Departamento',
            'p.created_at as paciente_created',
            'p.Primer_Nom as Primer_Nom',
            'p.SegundoNom as Segundo_Nom',
            'p.Primer_Ape as Primer_Ape',
            'p.Segundo_Ape as Segundo_Ape',
            'p.Tipo_Doc as Tipo_Doc',
            'p.Num_Doc as Cedula',
            'p.Edad_Cumplida as Edad_Cumplida',
            'p.Sexo as Sexo',
            'p.IPS as IpsAtencion',
            'p.Direccion_Residencia as Direccion_Residencia',
            'p.Correo1 as Correo',
            'p.Telefono as Telefono',
            'p.Celular1 as Celular',
            'p.Tipo_Afiliado as Tipo_Afiliado',
            'p.Estado_Afiliado as Estado_Afiliado',
            'm.Nombre as Municipio',
            'sede_paciente.Nombre as Nombre_IPS',
            'cie10.Codigo_CIE10 as Codigo_CIE10',
            'cie10.Descripcion as Descripcion_CIE10'])
        ->join('Cupordens as co', 'ordens.id', 'co.Orden_id')
        ->join('Users as user', 'ordens.Usuario_id', 'user.id')
        ->join('cita_paciente as cita_paciente', 'ordens.Cita_id', 'cita_paciente.id')
        ->join('Pacientes as p', 'cita_paciente.Paciente_id', 'p.id')
        ->join('Municipios as m', 'p.Mpio_Atencion', 'm.id')
        ->leftJoin('sedeproveedores as sede_paciente', 'p.IPS', 'sede_paciente.id')
        ->leftJoin('cie10pacientes as cie10p', 'cie10p.Citapaciente_id', 'cita_paciente.id')
        ->leftJoin('cie10s as cie10', 'cie10.id', 'cie10p.Cie10_id')
        ->with(['cupordens' => function ($query) use ($request) {
            $query->select(
                'Cupordens.id as id',
                'Cupordens.created_at as FechaSolicitud',
                'Cupordens.Cup_id as Cup',
                'Cupordens.Cantidad as Cup_Cantidad',
                'Cupordens.Orden_id as Orden_id',
                'Cupordens.Observacionorden as observaciones',
                'Cupordens.Estado_id as Estado_id',
                'c.id as Cup_Id',
                'c.Nombre as Cup_Nombre',
                'c.Codigo as Cup_Codigo',
                's.id as Sede_Id',
                's.Nombre as Sede_Nombre',
                's.Direccion as Sede_Direccion',
                's.Telefono1 as Sede_Telefono',
                'a.Nota as Auth_Nota',
                'a.updated_at as FechaAutorizacion',
                'u.name as Auth_Name',
                'u.apellido as Auth_Apellido',
                'u.Firma as Auth_Firma'
            )
                    ->join('Cups as c', 'Cupordens.Cup_id', 'c.id')
                    ->leftJoin('autorizacions as a', 'Cupordens.id', 'a.Cuporden_id')
                    ->leftJoin('Users as u', 'a.Usuario_id', 'u.id')
                    ->leftJoin('sedeproveedores as s', 'Cupordens.Ubicacion_id', 's.id')
                    ->where('Cupordens.Estado_id', $request->status)
                    ->get();
        }])
        ->where('co.Estado_id', $request->status)
        ->where('p.Num_Doc', $request->cedula)
        // ->where('cie10p.Esprimario', true)
        ->distinct()
        ->get();
        
        return response()->json($ordereds, 200);
        // return response()->json($cuporden, 200);
    }

    public function getState($type)
    {
        if ($type == 'Aprobado') {
            return 7;
        } elseif ($type == 'Pendiente') {
            return 15;
        }elseif ($type == 'Inadecuado') {
            return 24;
        } elseif ($type == 'Negado') {
            return 25;
        } elseif ($type == 'Anulado') {
            return 26;
        }
    }

    // public function updateAutMedicamentos($request, $type)
    // {

    //     $state = $this->getState($type);
        
    //     $detaarticulorden = Detaarticulorden::where('id', $request->idAutorizacion)
    //         ->update([
    //             'Estado_id' => $state
    //         ]);


    //     Autorizacion::create([
    //         "Articulorden_id" => $detaarticulorden->id,
    //         "Usuario_id" => auth()->id(),
    //         "Nota" => $request->observaciones
    //     ]);
    // }

    // public function updateAutServicios($request, $type)
    // {
    //     $state = $this->getState($type);

    //     $cuporden = Cuporden::where('id', $request->idAutorizacion)
    //             ->update([
    //                 'Estado_id' => $state
    //             ]);

    //     Autorizacion::create([
    //         "Cuporden_id" => $cuporden->id,
    //         "Usuario_id" => auth()->id(),
    //         "Nota" => $request->observaciones
    //     ]);
    // }

    public function autorizacionStateAprob(Request $request)
    {
        $type = 'Aprobado';

        if ($request->type == 'Medicamentos') {
            $state = $this->getState($type);

            foreach ($request->autorizaciones as $auth) {
                $detaarticulorden = Detaarticulorden::where('id', $auth['id'])->first();
                
                $detaarticulorden->update([
                    'Estado_id' => $state
                ]);

                $autorizacion = Autorizacion::where('Articulorden_id', $detaarticulorden->id)
                                    ->first();
                                    
                if (!isset($autorizacion)) {
                    Autorizacion::create([
                        "Articulorden_id" => $detaarticulorden->id,
                        "Usuario_id" => auth()->id(),
                        "Nota" => $request->observaciones
                    ]);
                } else {
                    $autorizacion->update([
                        "Usuario_id" => auth()->id(),
                        "Nota" => $request->observaciones
                    ]);
                }

                $msg = 'Actualizó el articulo '.$auth['Nombre'].' a estado Aprobado';

                Auditoria::create([
                    'Descripcion' => $msg,
                    'Tabla' => 'Detaarticulorden',
                    'Usuariomodifica_id' => auth()->user()->id,
                    'Model_id' => $detaarticulorden->id,
                    'Motivo' => $request->observaciones
                ]);
            }
        } elseif ($request->type == 'Servicios') {
            $state = $this->getState($type);

            foreach ($request->autorizaciones as $auth) {
                $cuporden = Cuporden::where('id', $auth['id'])->first();

                $cuporden->update([
                    'Estado_id' => $state
                ]);

                $autorizacion = Autorizacion::where('Cuporden_id', $cuporden->id)
                                    ->first();
                                    
                if (!isset($autorizacion)) {
                    Autorizacion::create([
                        "Cuporden_id" => $cuporden->id,
                        "Usuario_id" => auth()->id(),
                        "Nota" => $request->observaciones
                    ]);
                } else {
                    $autorizacion->update([
                        "Usuario_id" => auth()->id(),
                        "Nota" => $request->observaciones
                    ]);
                }

                $msg = 'Actualizó el Cup '.$auth['Cup_Nombre'].' a estado Aprobado';

                Auditoria::create([
                    'Descripcion' => $msg,
                    'Tabla' => 'Cuporden',
                    'Usuariomodifica_id' => auth()->user()->id,
                    'Model_id' => $cuporden->id,
                    'Motivo' => $request->observaciones
                ]);
            }
        }

        return response()->json('Autorización Aprobada de manera exitosa', 200);
    }

    public function autorizacionStateInad(Request $request)
    {
        $type = 'Inadecuado';

        if ($request->type == 'Medicamentos') {
            $state = $this->getState($type);

            foreach ($request->autorizaciones as $auth) {
                $detaarticulorden = Detaarticulorden::where('id', $auth['id'])->first();
                
                $detaarticulorden->update([
                    'Estado_id' => $state
                ]);

                $autorizacion = Autorizacion::where('Articulorden_id', $detaarticulorden->id)
                                    ->first();
                                    
                if (!isset($autorizacion)) {
                    Autorizacion::create([
                        "Articulorden_id" => $detaarticulorden->id,
                        "Usuario_id" => auth()->id(),
                        "Nota" => $request->observaciones
                    ]);
                } else {
                    $autorizacion->update([
                        "Usuario_id" => auth()->id(),
                        "Nota" => $request->observaciones
                    ]);
                }

                $msg = 'Actualizó el articulo '.$auth['Nombre'].' a estado Inadecuado';

                Auditoria::create([
                    'Descripcion' => $msg,
                    'Tabla' => 'Detaarticulorden',
                    'Usuariomodifica_id' => auth()->user()->id,
                    'Model_id' => $detaarticulorden->id,
                    'Motivo' => $request->observaciones
                ]);
            }

            // $this->updateAutMedicamentos($request, $type);
        } elseif ($request->type == 'Servicios') {
            $state = $this->getState($type);

            foreach ($request->autorizaciones as $auth) {
                $cuporden = Cuporden::where('id', $auth['id'])->first();

                $cuporden->update([
                    'Estado_id' => $state
                ]);

                $autorizacion = Autorizacion::where('Cuporden_id', $cuporden->id)
                                    ->first();
                                    
                if (!isset($autorizacion)) {
                    Autorizacion::create([
                        "Cuporden_id" => $cuporden->id,
                        "Usuario_id" => auth()->id(),
                        "Nota" => $request->observaciones
                    ]);
                } else {
                    $autorizacion->update([
                        "Usuario_id" => auth()->id(),
                        "Nota" => $request->observaciones
                    ]);
                }

                $msg = 'Actualizó el Cup '.$auth['Cup_Nombre'].' a estado Inadecuado';

                Auditoria::create([
                    'Descripcion' => $msg,
                    'Tabla' => 'Cuporden',
                    'Usuariomodifica_id' => auth()->user()->id,
                    'Model_id' => $cuporden->id,
                    'Motivo' => $request->observaciones
                ]);
            }
            // $this->updateAutServicios($request, $type);
        }

        return response()->json('Autorización en estado Inadecuada de manera exitosa', 200);
    }

    public function autorizacionStateNeg(Request $request)
    {
        $type = 'Negado';

        if ($request->type == 'Medicamentos') {
            $state = $this->getState($type);

            foreach ($request->autorizaciones as $auth) {
                $detaarticulorden = Detaarticulorden::where('id', $auth['id'])->first();
                
                $detaarticulorden->update([
                    'Estado_id' => $state
                ]);

                $autorizacion = Autorizacion::where('Articulorden_id', $detaarticulorden->id)
                                    ->first();
                                    
                if (!isset($autorizacion)) {
                    Autorizacion::create([
                        "Articulorden_id" => $detaarticulorden->id,
                        "Usuario_id" => auth()->id(),
                        "Nota" => $request->observaciones
                    ]);
                } else {
                    $autorizacion->update([
                        "Usuario_id" => auth()->id(),
                        "Nota" => $request->observaciones
                    ]);
                }

                $msg = 'Actualizó el articulo '.$auth['Nombre'].' a estado Negado';

                Auditoria::create([
                    'Descripcion' => $msg,
                    'Tabla' => 'Detaarticulorden',
                    'Usuariomodifica_id' => auth()->user()->id,
                    'Model_id' => $detaarticulorden->id,
                    'Motivo' => $request->observaciones
                ]);
            }

            // $this->updateAutMedicamentos($request, $type);
        } elseif ($request->type == 'Servicios') {
            $state = $this->getState($type);

            foreach ($request->autorizaciones as $auth) {
                $cuporden = Cuporden::where('id', $auth['id'])->first();

                $cuporden->update([
                    'Estado_id' => $state
                ]);

                $autorizacion = Autorizacion::where('Cuporden_id', $cuporden->id)
                                    ->first();
                                    
                if (!isset($autorizacion)) {
                    Autorizacion::create([
                        "Cuporden_id" => $cuporden->id,
                        "Usuario_id" => auth()->id(),
                        "Nota" => $request->observaciones
                    ]);
                } else {
                    $autorizacion->update([
                        "Usuario_id" => auth()->id(),
                        "Nota" => $request->observaciones
                    ]);
                }

                $msg = 'Actualizó el Cup '.$auth['Cup_Nombre'].' a estado Negado';

                Auditoria::create([
                    'Descripcion' => $msg,
                    'Tabla' => 'Cuporden',
                    'Usuariomodifica_id' => auth()->user()->id,
                    'Model_id' => $cuporden->id,
                    'Motivo' => $request->observaciones
                ]);
            }
            // $this->updateAutServicios($request, $type);
        }

        return response()->json('Autorización modificada de manera exitosa', 200);
    }

    public function autorizacionStateAnu(Request $request)
    {
        $type = 'Anulado';

        if ($request->type == 'Medicamentos') {
            $state = $this->getState($type);
        
            foreach ($request->autorizaciones as $auth) {
                $detaarticulorden = Detaarticulorden::where('id', $auth['id'])->first();
                
                $detaarticulorden->update([
                    'Estado_id' => $state
                ]);

                $autorizacion = Autorizacion::where('Articulorden_id', $detaarticulorden->id)
                                    ->first();
                                    
                if (!isset($autorizacion)) {
                    Autorizacion::create([
                        "Articulorden_id" => $detaarticulorden->id,
                        "Usuario_id" => auth()->id(),
                        "Nota" => $request->observaciones
                    ]);
                } else {
                    $autorizacion->update([
                        "Usuario_id" => auth()->id(),
                        "Nota" => $request->observaciones
                    ]);
                }

                $msg = 'Actualizó el articulo '.$auth['Nombre'].' a estado Anulada';

                Auditoria::create([
                    'Descripcion' => $msg,
                    'Tabla' => 'Detaarticulorden',
                    'Usuariomodifica_id' => auth()->user()->id,
                    'Model_id' => $detaarticulorden->id,
                    'Motivo' => $request->observaciones
                ]);
            }

            // $test = $this->updateAutMedicamentos($request, $type);
        } elseif ($request->type == 'Servicios') {
            $state = $this->getState($type);

            foreach ($request->autorizaciones as $auth) {
                $cuporden = Cuporden::where('id', $auth['id'])->first();

                $cuporden->update([
                    'Estado_id' => $state
                ]);

                $autorizacion = Autorizacion::where('Cuporden_id', $cuporden->id)
                                    ->first();
                                    
                if (!isset($autorizacion)) {
                    Autorizacion::create([
                        "Cuporden_id" => $cuporden->id,
                        "Usuario_id" => auth()->id(),
                        "Nota" => $request->observaciones
                    ]);
                } else {
                    $autorizacion->update([
                        "Usuario_id" => auth()->id(),
                        "Nota" => $request->observaciones
                    ]);
                }

                $msg = 'Actualizó el Cup '.$auth['Cup_Nombre'].' a estado Anulada';

                Auditoria::create([
                    'Descripcion' => $msg,
                    'Tabla' => 'Cuporden',
                    'Usuariomodifica_id' => auth()->user()->id,
                    'Model_id' => $cuporden->id,
                    'Motivo' => $request->observaciones
                ]);

                // $this->updateAutServicios($request, $type);
            }

            return response()->json('Autorización modificada de manera exitosa', 200);
        }
    }

    public function updateMedicamento(Detaarticulorden $detaarticulorden, Request $request)
    {
        $detaarticulorden->update([
            'NumMeses' => $request->Num_Meses,
            'Cantidadpormedico' => $request->Cantidad_Medico
        ]);

        return response()->json([
            'message' => 'Detalle Articulo Orden'
        ], 201);
    }

    public function updateServicio(Cuporden $cuporden, Request $request)
    {
        $cuporden->update([
            'Cantidad' => $request->Cup_Cantidad
        ]);

        return response()->json([
            'message' => 'Cup Orden'
        ], 201);
    }

    public function getExcelForMedicamentos(Request $request) 
    {
        $detaarticulorden = Detaarticulorden::select(
            'Detaarticulordens.id as id',
            'Detaarticulordens.created_at as FechaSolicitud',
            'Detaarticulordens.Cantidadosis as Cantidad_Dosis',
            'Detaarticulordens.codesumi_id as Codesumi_id',
            'Detaarticulordens.Via as Via',
            'Detaarticulordens.Unidadmedida as Unidad_Medida',
            'Detaarticulordens.Frecuencia as Frecuencia',
            'Detaarticulordens.Unidadtiempo as Unidad_Tiempo',
            'Detaarticulordens.Duracion as Duracion',
            'Detaarticulordens.Cantidadmensual as Cantidad_Mensual',
            'Detaarticulordens.Nummeses as Num_Meses',
            'Detaarticulordens.Observacion as Observacion',
            'Detaarticulordens.Cantidadpormedico as Cantidad_Medico',
            'Detaarticulordens.Orden_id as Orden_id',
            'Detaarticulordens.Fechaorden as Fecha_Orden',
            'Detaarticulordens.Estado_id as Estado_id',
            'Users.name as User_Name',
            'Users.apellido as User_LastName',
            'Pacientes.Departamento',
            'Pacientes.created_at',
            'Pacientes.Primer_Nom as Primer_Nom',
            'Pacientes.SegundoNom as Segundo_Nom',
            'Pacientes.Primer_Ape as Primer_Ape',
            'Pacientes.Segundo_Ape as Segundo_Ape',
            'Pacientes.Tipo_Doc as Tipo_Doc',
            'Pacientes.Num_Doc as Cedula',
            'Pacientes.Edad_Cumplida as Edad_Cumplida',
            'Pacientes.Sexo as Sexo',
            'Pacientes.IPS as IpsAtencion',
            'Pacientes.Direccion_Residencia as Direccion_Residencia',
            'Pacientes.Correo1 as Correo',
            'Pacientes.Telefono as Telefono',
            'Pacientes.Tipo_Afiliado as Tipo_Afiliado',
            'Pacientes.Estado_Afiliado as Estado_Afiliado',
            'Municipios.Nombre as Municipio',
            'cita_paciente.id as citaPaciente_id',
            'codesumis.Nombre as Nombre',
            'codesumis.Codigo as Codigo',
            'codesumis.Requiere_autorizacion as Requiere_Autorizacion',
            'sedeproveedores.Nombre as Nombre_IPS',
            'sedeproveedores.Direccion as Direccion_IPS',
            'sedeproveedores.Telefono1 as Telefono_IPS',
            'cie10s.Codigo_CIE10 as Codigo_CIE10',
            'cie10s.Descripcion as Descripcion_CIE10',
            'autorizacions.Nota as Auth_Nota',
            'autorizacions.updated_at as FechaAutorizacion',
            'u.name as Auth_Name',
            'u.apellido as Auth_Apellido',
        )
            ->join('Ordens', 'Detaarticulordens.Orden_id', 'Ordens.id')
            ->leftJoin('autorizacions', 'Detaarticulordens.id', 'autorizacions.Articulorden_id')
            ->join('Users', 'Ordens.Usuario_id', 'Users.id')
            ->leftJoin('Users as u', 'autorizacions.Usuario_id', 'u.id')
            ->join('cita_paciente', 'Ordens.Cita_id', 'cita_paciente.id')
            ->join('Pacientes', 'cita_paciente.Paciente_id', 'Pacientes.id')
            ->join('Municipios', 'Pacientes.Mpio_Atencion', 'Municipios.id')
            ->leftJoin('sedeproveedores', 'Pacientes.IPS', 'sedeproveedores.id')
            ->join('codesumis', 'Detaarticulordens.Codesumi_id', 'codesumis.id')
            ->leftJoin('cie10pacientes', 'cie10pacientes.Citapaciente_id', 'cita_paciente.id')
            ->leftJoin('cie10s', 'cie10s.id', 'cie10pacientes.Cie10_id')
            ->where('Detaarticulordens.Estado_id', $request->status)
            ->whereBetween('Detaarticulordens.Fechaorden', [$request->fechaStart, $request->fechaEnd])
                        
            ->get();

            return response()->json($detaarticulorden, 200);
    }

    public function getExcelForServicios(Request $request) 
    {
        $cuporden = Cuporden::select(
            'Cupordens.id as id',
            'Cupordens.created_at as FechaSolicitud',
            'Cupordens.Cup_id as Cup',
            'Cupordens.Cantidad as Cup_Cantidad',
            'Cupordens.Orden_id as Orden_id',
            'Cupordens.Observacionorden as observaciones',
            'Cupordens.Estado_id as Estado_id',
            'Users.name as User_Name',
            'Users.apellido as User_LastName',
            'Pacientes.Departamento',
            'Pacientes.created_at',
            'Pacientes.Primer_Nom as Primer_Nom',
            'Pacientes.SegundoNom as Segundo_Nom',
            'Pacientes.Primer_Ape as Primer_Ape',
            'Pacientes.Segundo_Ape as Segundo_Ape',
            'Pacientes.Tipo_Doc as Tipo_Doc',
            'Pacientes.Num_Doc as Cedula',
            'Pacientes.Edad_Cumplida as Edad_Cumplida',
            'Pacientes.Sexo as Sexo',
            'Pacientes.IPS as IpsAtencion',
            'Pacientes.Direccion_Residencia as Direccion_Residencia',
            'Pacientes.Correo1 as Correo',
            'Pacientes.Telefono as Telefono',
            'Pacientes.Tipo_Afiliado as Tipo_Afiliado',
            'Pacientes.Estado_Afiliado as Estado_Afiliado',
            'Municipios.Nombre as Municipio',
            'Cups.id as Cup_Id',
            'Cups.Codigo as Cup_Codigo',
            'Cups.Nombre as Cup_Nombre',
            'Sedeproveedores.Nombre as Sede_Nombre',
            'sedeproveedores.Direccion as Sede_Direccion',
            'sedeproveedores.Telefono1 as Sede_Telefono',
            'sede_paciente.Nombre as Nombre_IPS',
            'cita_paciente.id as citaPaciente_id',
            'cie10s.Codigo_CIE10 as Codigo_CIE10',
            'cie10s.Descripcion as Descripcion_CIE10',
            'autorizacions.Nota as Auth_Nota',
            'autorizacions.updated_at as FechaAutorizacion'
        )
                ->join('Ordens', 'Cupordens.Orden_id', 'Ordens.id')
                ->leftJoin('autorizacions', 'Cupordens.id', 'autorizacions.Cuporden_id')
                ->join('Users', 'Ordens.Usuario_id', 'Users.id')
                ->join('cita_paciente', 'Ordens.Cita_id', 'cita_paciente.id')
                ->join('Cups', 'Cups.id', 'Cupordens.Cup_id')
                ->join('Pacientes', 'cita_paciente.Paciente_id', 'Pacientes.id')
                ->join('Municipios', 'Pacientes.Mpio_Atencion', 'Municipios.id')
                ->leftJoin('cie10pacientes', 'cie10pacientes.Citapaciente_id', 'cita_paciente.id')
                ->leftJoin('cie10s', 'cie10s.id', 'cie10pacientes.Cie10_id')
                ->leftJoin('Sedeproveedores', 'Cupordens.Ubicacion_id', 'Sedeproveedores.id')
                ->leftJoin('Sedeproveedores as sede_paciente', 'Pacientes.IPS', 'sede_paciente.id')
                ->where('Cupordens.Estado_id', $request->status)
                ->whereBetween('Cupordens.created_at', [$request->fechaStart, $request->fechaEnd])
                ->get();

                return response()->json($cuporden, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modelos\Autorizacion  $autorizacion
     * @return \Illuminate\Http\Response
     */
    public function show(Autorizacion $autorizacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modelos\Autorizacion  $autorizacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Autorizacion $autorizacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modelos\Autorizacion  $autorizacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Autorizacion $autorizacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modelos\Autorizacion  $autorizacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Autorizacion $autorizacion)
    {
        //
    }
}
