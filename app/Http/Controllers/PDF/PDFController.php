<?php
// Our Controller
namespace App\Http\Controllers\PDF;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Modelos\citapaciente;
use App\Modelos\Orden;
// This is important to add here.
use PDF;

class PDFController extends Controller
{
    public function print(Request $request)
    {

        if (!empty($request->fecha_solicitud)) {
            $fecha_estimada = date("Y-m-d", strtotime("+". 1 ." months", strtotime($request->fecha_solicitud)));
        } else {
            $fecha_estimada = date("Y-m-d", strtotime("+". 1 ." months"));
        }

        $data = [
                'Oftalmologico' => $request->Oftalmologico,
                'Genitourinario' => $request->Genitourinario,
                'Otorrinoralingologico' => $request->Otorrinoralingologico,
                'Linfatico' => $request->Linfatico,
                'Osteomioarticular' => $request->Osteomioarticular,
                'Neurologico' => $request->Neurologico,
                'Cardiovascular' => $request->Cardiovascular,
                'Tegumentario' => $request->Tegumentario,
                'Respiratorio' => $request->Respiratorio,
                'Endocrinologico' => $request->Endocrinologico,
                'Gastrointestinal' => $request->Gastrointestinal,
                'Norefiere' => $request->Norefiere,
                'NombreAntecedente' => $request->NombreAntecedente,
                'logo' => $request->logo,
                'identificacion' => $request->Num_Doc,
                'Cédula' => $request->Cédula,
                'Fecha_Nacimiento' => $request->Fecha_Nacimiento,
                'Departamento' => $request->Departamento,
                'Municipio_Afiliado' => $request->Municipio_Afiliado,
                'Direccion_Residencia' => $request->Direccion_Residencia,
                'Laboraen' => $request->Laboraen,
                'Motivoconsulta' => $request->Motivoconsulta,
                'Enfermedadactual' => $request->Enfermedadactual,
                'Antropometricas' => $request->Antropometricas,
                'Signos_Vitales' => $request->Signos_Vitales,
                'Otros_Signos_Vitales' => $request->Otros_Signos_Vitales,
                'Presión_Arterial' => $request->Presión_Arterial,
                'Condiciongeneral' => $request->Condiciongeneral,
                'Planmanejo' => $request->Planmanejo,
                'Diagnostico_Principal' => $request->Diagnostico_Principal,
                'Diagnostico_Secundario' => $request->Diagnostico_Secundario,
                'Antecedentes' => $request->Antecedentes,
                'Abdomen' => $request->Abdomen,
                'Agudezavisual' => $request->Agudezavisual,
                'Cabezacuello' => $request->Cabezacuello,
                'Cardiopulmonar' => $request->Cardiopulmonar,
                'Examenmama' => $request->Examenmama,
                'Examenmental' => $request->Examenmental,
                'Extremidades' => $request->Extremidades,
                'Frecucardiaca' => $request->Frecucardiaca,
                'Frecurespiratoria' => $request->Frecurespiratoria,
                'Genitourinario' => $request->Genitourinario,
                'Neurologico' => $request->Neurologico,
                'Ojosfondojos' => $request->Ojosfondojos,
                'Osteomuscular' => $request->Osteomuscular,
                'Pielfraneras' => $request->Pielfraneras,
                'Reflejososteotendinos' => $request->Reflejososteotendinos,
                'Tactoretal' => $request->Tactoretal,
                'Dietasaludable' => $request->Dietasaludable,
                'Suenoreparador' => $request->Suenoreparador,
                'Duermemenoseishoras' => $request->Duermemenoseishoras,
                'Altonivelestres' => $request->Altonivelestres,
                'Actividadfisica' => $request->Actividadfisica,
                'Frecuenciasemana' => $request->Frecuenciasemana,
                'Duracion' => $request->Duracion,
                'Fumacantidad' => $request->Fumacantidad,
                'Fumainicio' => $request->Fumainicio,
                'Fumadorpasivo' => $request->Fumadorpasivo,
                'Cantidadlicor' => $request->Cantidadlicor,
                'Licorfrecuencia' => $request->Licorfrecuencia,
                'Consumopsicoactivo' => $request->Consumopsicoactivo,
                'Psicoactivocantidad' => $request->Psicoactivocantidad,
                'Estilovidaobservaciones' => $request->Estilovidaobservaciones,
                'Tipodiagnostico' => $request->Tipodiagnostico,
                'Recomendaciones' => $request->Recomendaciones,
                'Finalidad' => $request->Finalidad,
                'Destinopaciente' => $request->Destinopaciente,
                'Atendido_Por' => $request->Atendido_Por,
                'Cedulamedico' => $request->Cedulamedico,
                'Registromedico' => $request->Registromedico,
                'Firma' => $request->Firma,
                'nombre' => $request->Primer_Nom . ' ' . $request->Segundo_Nom . ' ' . $request->Primer_Ape . ' ' . $request->Segundo_Ape,
                'Nombre' => $request->Nombre,
                'Especialidad' => $request->Especialidad,
                'Firma' => $request->Firma,
                'Firma_Auditor' => $request->Firma_Auditor,
                'edad' => $request->Edad_Cumplida,
                'sexo' => $request->Sexo,
                'ips' => $request->IPS,
                'direccion' => $request->Direccion_Residencia,
                'aseguradora' => $request->aseguradora,
                'correo' => $request->Correo,
                'telefono' => $request->Telefono,
                'celular' => $request->Celular,
                'Tipo_Afiliado' => $request->Tipo_Afiliado,
                'estado_afiliado' => $request->Estado_Afiliado,
                'fecha_solicitud' => $request->fecha_solicitud,
                'dx_principal' => $request->dx_principal,
                'grupo_farmaceutico' => $request->grupo_farmaceutico,
                'medicamento' => $request->medicamento,
                'cantidad_dosis' => $request->cantidad_dosis,
                'via' => $request->via,
                'frecuencia' => $request->frecuencia,
                'unidad_tiempo' => $request->unidad_tiempo,
                'duracion' => $request->duracion,
                'cantidad_mensual' => $request->cantidad_mensual,
                'renovable' => $request->renovable,
                'observaciones' => $request->observaciones,
                'sede' => $request->sede,
                'prestador' => $request->prestador,
                'servicio' => $request->servicio,
                'medico_tratante' => $request->medico_tratante,
                'medico_ordena' => $request->medico_ordena,
                'autorizado' => $request->autorizado,
                'firma_digital' => $request->firma_digital,
                'fecha_formula' => $request->fecha_formula,
                'autorizacion' => $request->autorizacion,
                'medicamentos' => $request->medicamentos,
                'servicios' => $request->servicios,
                'FechaInicio' => $request->FechaInicio,
                'CantidadDias' => $request->CantidadDias,
                'FechaFinal' => $request->FechaFinal,
                'Prorroga' => $request->Prorroga,
                'Cie10' => $request->Cie10,
                'Contingencia' => $request->Contingencia,
                'Descripcion' => $request->Descripcion,
                'Firma' => $request->Firma,
                'TextCie10' => $request->TextCie10,
                'order_id' => $request->orden_id,
                'tipo_cita' => $request->Tipo_cita,
                'Especialidad' => $request->Especialidad,
                'Fecha_actual' => date("Y-m-d"),
                'Fecha_estimada' => $fecha_estimada,
                'Datetimeingreso' => $request->Datetimeingreso
            ];

        if ($request->type == 'formula') {
            $pdf = PDF::loadView('pdf_view_formula', $data);
        } elseif ($request->type == 'pendiente') {
            $pdf = PDF::loadView('pdf_view_pendientes', $data);
        } elseif ($request->type == 'ordenamiento') {
            $pdf = PDF::loadView('pdf_view_ordenamiento', $data);
        } elseif ($request->type == 'autorizacion') {
            $pdf = PDF::loadView('pdf_view_autorizacion', $data);
        } elseif ($request->type == 'medicamentos') {
            $pdf = PDF::loadView('pdf_view_medicamentos', $data);
        } elseif ($request->type == 'envio') {
            $pdf = PDF::loadView('pdf_view_envio', $data);
        } elseif ($request->type == 'observacion') {
            $pdf = PDF::loadView('pdf_view_observacion', $data);
        } elseif ($request->type == 'incapacidad') {
            $pdf = PDF::loadView('pdf_view_incapacidad', $data);
        } elseif ($request->type == 'otros') {
            $pdf = PDF::loadView('pdf_view_servicios', $data);
        } elseif ($request->type == 'cita') {
            $pdf = PDF::loadView('pdf_view_cita', $data);
        } elseif ($request->type == 'test') {
            $pdf = PDF::loadView('pdf_historiaclinica', $data);
        }
    
        $customPaper = array(0,0,792,612);
        // $pdf->setPaper('a4', 'landscape');
        $pdf->setPaper('a4', 'portrait');

        if ($request->SendEmail) {

            // $email = Mail::send('ruta de la vista ej: emails.prueba',
            // ['correo' => $correo], function ($m) use ($correo) {
            //     $m->to($correo->email, $correo->name)->subject('Nombre del asunto');  
            // });

            $data = array(
                'name' => 'Juan',
                'phone' => '301',
                'email' => 'paltair05@gmail.com',
                'bodyMessage' => 'This is '
            );


            //Feedback mail to client
            //$pdf = PDF::loadView('your_view_name', $data)->setPaper('a4'); 
            $email = Mail::send('send_mail', $data, function($message) use ($data,$pdf){
                $message->from('juanpa96@live.com.mx');
                $message->to($data['email']);
                $message->subject('Thank you message');
                //Attach PDF doc
                $message->attachData($pdf->output(),'customer.pdf');
            });
        }
        // $pdf = PDF::loadView('pdf_view_envio', $data);
        // $pdf->download();
        // $dom_pdf = $pdf->getDomPDF();
        // $canvas = $dom_pdf ->get_canvas();
        // $canvas->page_text(0, 0, "{PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->download();
    }

}
