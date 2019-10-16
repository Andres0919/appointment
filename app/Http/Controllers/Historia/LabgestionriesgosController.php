<?php

namespace App\Http\Controllers\Historia;


use App\Modelos\citapaciente;
use App\Modelos\Labgestionriesgos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LabgestionriesgosController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request, citapaciente $citapaciente)
    {
        $labgestionriesgos = Labgestionriesgos::where('Labgestionriesgos.Citapaciente_id', $citapaciente->id)->first();

        if (isset($labgestionriesgos)) {
           $labgestionriesgos->update([
                'Glicemiafecha' => $request->Glicemiafecha,
                'Glicemia' => $request->Glicemia,
                'Hemoglobinaglicosilada' => $request->Hemoglobinaglicosilada,
                'Hemoglobinafecha' => $request->Hemoglobinafecha,
                'Colesteroltotal' => $request->Colesteroltotal,
                'Colesteroltotalfecha' => $request->Colesteroltotalfecha,
                'Colesterolhdl' => $request->Colesterolhdl,
                'Colesterolhdlfecha' => $request->Colesterolhdlfecha,
                'Colesterolldl' => $request->Colesterolldl,
                'Colesterolldlfecha' => $request->Colesterolldlfecha,
                'Trigliceridos' => $request->Trigliceridos,
                'Trigliceridosfecha' => $request->Trigliceridosfecha,
                'Proteinuria' => $request->Proteinuria,
                'Proteinuriafecha' => $request->Proteinuriafecha,
                'Uroanalisis' => $request->Uroanalisis,
                'Uroanalisisfecha' => $request->Uroanalisisfecha,
                'Microalbuminuria' => $request->Microalbuminuria,
                'Microalbuminuriafecha' => $request->Microalbuminuriafecha,
                'Creatinina' => $request->Creatinina,
                'Creatininafecha' => $request->Creatininafecha,
                'Disminuciondetfg' => $request->Disminuciondetfg,
                'Resultadoframinghan' => $request->Resultadoframinghan,
                'Cumplemetaterapeutica' => $request->Cumplemetaterapeutica,
                'Pacienteadherente' => $request->Pacienteadherente,
                'Pacientecontrolado' => $request->Pacientecontrolado,
                'Insulinorequiriente' => $request->Insulinorequiriente,
                'Signosdealarma' => $request->Signosdealarma,
                'Hospitalizacionesrecientes' => $request->Hospitalizacionesrecientes,
                'Valoracionpornutricion' => $request->Valoracionpornutricion,
                'Valoracionporpsicologia' => $request->Valoracionporpsicologia,
                'Asisteatallergrupaleducativo' => $request->Asisteatallergrupaleducativo,
                'Periodicidadproximocontrol' => $request->Periodicidadproximocontrol,
                'Proximocontrolcon' => $request->Proximocontrolcon,
           ]);
           return response()->json(['message' => 'Programa cardio vascular actualizado con exito!'], 201);
        }else {
            Labgestionriesgos::create([

                'Citapaciente_id' => $citapaciente->id,
                'Glicemiafecha' => $request->Glicemiafecha,
                'Glicemia' => $request->Glicemia,
                'Hemoglobinaglicosilada' => $request->Hemoglobinaglicosilada,
                'Hemoglobinafecha' => $request->Hemoglobinafecha,
                'Colesteroltotal' => $request->Colesteroltotal,
                'Colesteroltotalfecha' => $request->Colesteroltotalfecha,
                'Colesterolhdl' => $request->Colesterolhdl,
                'Colesterolhdlfecha' => $request->Colesterolhdlfecha,
                'Colesterolldl' => $request->Colesterolldl,
                'Colesterolldlfecha' => $request->Colesterolldlfecha,
                'Trigliceridos' => $request->Trigliceridos,
                'Trigliceridosfecha' => $request->Trigliceridosfecha,
                'Proteinuria' => $request->Proteinuria,
                'Proteinuriafecha' => $request->Proteinuriafecha,
                'Uroanalisis' => $request->Uroanalisis,
                'Uroanalisisfecha' => $request->Uroanalisisfecha,
                'Microalbuminuria' => $request->Microalbuminuria,
                'Microalbuminuriafecha' => $request->Microalbuminuriafecha,
                'Creatinina' => $request->Creatinina,
                'Creatininafecha' => $request->Creatininafecha,
                'Disminuciondetfg' => $request->Disminuciondetfg,
                'Resultadoframinghan' => $request->Resultadoframinghan,
                'Cumplemetaterapeutica' => $request->Cumplemetaterapeutica,
                'Pacienteadherente' => $request->Pacienteadherente,
                'Pacientecontrolado' => $request->Pacientecontrolado,
                'Insulinorequiriente' => $request->Insulinorequiriente,
                'Signosdealarma' => $request->Signosdealarma,
                'Hospitalizacionesrecientes' => $request->Hospitalizacionesrecientes,
                'Valoracionpornutricion' => $request->Valoracionpornutricion,
                'Valoracionporpsicologia' => $request->Valoracionporpsicologia,
                'Asisteatallergrupaleducativo' => $request->Asisteatallergrupaleducativo,
                'Periodicidadproximocontrol' => $request->Periodicidadproximocontrol,
                'Proximocontrolcon' => $request->Proximocontrolcon,
            ]);
            return response()->json(['message' => 'Programa cardio vascular guardado con exito!'], 201);
        }
        
    }

    public function getLabgestion() {
        $labgestionriesgos = Labgestionriesgos::select(
            'Citapaciente_id',
                'Glicemiafecha',
                'Glicemia',
                'Hemoglobinaglicosilada',
                'Hemoglobinafecha',
                'Colesteroltotal',
                'Colesteroltotalfecha',
                'Colesterolhdl',
                'Colesterolhdlfecha',
                'Colesterolldl',
                'Colesterolldlfecha',
                'Trigliceridos',
                'Trigliceridosfecha',
                'Proteinuria',
                'Proteinuriafecha',
                'Uroanalisis',
                'Uroanalisisfecha',
                'Microalbuminuria',
                'Microalbuminuriafecha',
                'Creatinina',
                'Creatininafecha',
                'Disminuciondetfg',
                'Resultadoframinghan',
                'Cumplemetaterapeutica',
                'Pacienteadherente',
                'Pacientecontrolado',
                'Insulinorequiriente',
                'Signosdealarma',
                'Hospitalizacionesrecientes',
                'Valoracionpornutricion',
                'Valoracionporpsicologia',
                'Asisteatallergrupaleducativo',
                'Periodicidadproximocontrol',
                'Proximocontrolcon')
                ->where('Labgestionriesgos.Citapaciente_id', $citapaciente->id)
                ->first();

         return response()->json([ 'labgestionriesgos' => $labgestionriesgos ], 201);
    }

    public function show(Labgestionriesgos $labgestionriesgos)
    {
        //
    }

    public function edit(Labgestionriesgos $labgestionriesgos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modelos\Labgestionriesgos  $labgestionriesgos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Labgestionriesgos $labgestionriesgos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modelos\Labgestionriesgos  $labgestionriesgos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Labgestionriesgos $labgestionriesgos)
    {
        //
    }
}
