<template>
    <v-container>
        <v-layout row wrap>
            <v-flex xs4 md3 lg3>
                <v-text-field v-model="cedula" type="number" label="Cédula" outlined></v-text-field>
            </v-flex>
            <v-spacer></v-spacer>
            <v-flex xs2 md3 lg3>
                <v-btn color="primary" round @click="find()">Buscar</v-btn>
            </v-flex>
            <v-spacer></v-spacer>
            <v-flex xs2 md3 lg3>
            </v-flex>
        </v-layout>
        <v-layout row>
            <v-dialog v-model="dialog" max-width="1000px">
                <v-card>
                    <v-toolbar flat color="primary" dark>
                        <v-toolbar-title>Historia Clinica</v-toolbar-title>
                    </v-toolbar>
                    <v-tabs vertical>
                        <v-tab>
                            <v-icon left>mdi-account</v-icon>Información del paciente
                        </v-tab>
                        <v-tab>
                            <v-icon left>list_alt</v-icon>Diagnostico
                        </v-tab>

                        <v-tab-item>
                            <v-flex>
                                <v-card flat>
                                    <v-card-title class="headline grey lighten-2">Datos del paciente</v-card-title>
                                    <v-container>
                                        <v-layout wrap align-center>
                                            <v-flex xs6 md3 lg5 class="pr-5">
                                                <v-text-field v-model="inc.Nombre" label="Nombre" outlined readonly>
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs6 md3 lg2 class="pr-5">
                                                <v-text-field v-model="inc.Cedula" label="Cédula" outlined readonly>
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs6 md3 lg1 class="pr-5">
                                                <v-text-field v-model="inc.Edad_Cumplida" label="edad" outlined
                                                    readonly></v-text-field>
                                            </v-flex>
                                            <v-flex xs6 md3 lg1 class="pr-5">
                                                <v-text-field v-model="inc.Sexo" label="sexo" outlined readonly>
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs6 md3 lg2 class="pr-5">
                                                <v-text-field v-model="inc.Celular" label="Celular" outlined readonly>
                                                </v-text-field>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                    <v-container>
                                        <v-textarea v-if="inc.Estado_id == 1 && can('auditoria.incapacidad.anular')" name="input-7-1" label="Observacion" value v-model="observaciones">
                                        </v-textarea>
                                    </v-container>
                                </v-card>
                            </v-flex>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card flat>
                                <v-card-title class="headline grey lighten-2">Diagnosticos</v-card-title>
                                <v-data-table class="fb-table-elem" :headers="diagnosticHeaders" :items="Diagnosticos"
                                    item-key="id" :items-per-page="5" hide-actions expand>
                                    <template v-slot:items="Diagnostico">
                                        <tr @click="Diagnostico.expanded = !Diagnostico.expanded">
                                            <td class="text-xs-center">
                                                <div class="datatable-cell-wrapper">
                                                    <v-checkbox disabled color="primary"
                                                        v-model="Diagnostico.item.Esprimario" hide-details
                                                        :value="Diagnostico.item.Esprimario"></v-checkbox>
                                                </div>
                                            </td>
                                            <td class="text-xs-center">
                                                <div class="datatable-cell-wrapper">{{ Diagnostico.item.Cie10_id }}
                                                </div>
                                            </td>
                                            <td class="text-xs-center">
                                                <div class="datatable-cell-wrapper">
                                                    {{ Diagnostico.item.Tipodiagnostico }}</div>
                                            </td>
                                            <td class="text-xs-center">
                                                <div class="datatable-cell-wrapper">
                                                    <v-select :items="Diagnostico.item.Marcapaciente"
                                                        label="Marcar paciente" v-model="Diagnostico.item.Marcapaciente"
                                                        attach multiple chips></v-select>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                    <v-alert v-slot:no-results :value="true" color="error" icon="warning">Your search
                                        for "{{ search }}" found no results.</v-alert>
                                    <template slot="expand" slot-scope="Diagnostico">
                                        <v-card flat>
                                            <v-card-text>
                                                <pre>{{Diagnostico}}</pre>
                                            </v-card-text>
                                            <div class="datatable-container">
                                                <v-card-text>
                                                    <pre>{{Diagnostico}}</pre>
                                                </v-card-text>
                                            </div>
                                        </v-card>
                                    </template>
                                </v-data-table>
                            </v-card>
                        </v-tab-item>
                    </v-tabs>
                </v-card>
                <v-card>
                    <v-layout row wrap>
                        <v-flex xs3 md3 lg3>
                            <v-card-actions>
                                <v-btn color="blue darken-1" flat @click="cerrarModal()">Cerrar</v-btn>
                            </v-card-actions>
                        </v-flex>
                        <v-flex xs3 md3 lg3>
                            <v-tooltip top>
                                <template v-slot:activator="{ on }">
                                    <v-btn v-if="inc.Estado_id == 1" text icon color="green" dark v-on="on">
                                        <v-icon @click="print()">assignment_turned_in</v-icon>
                                    </v-btn>
                                </template>
                                <span>Incapacidad</span>
                            </v-tooltip>
                        </v-flex>
                        <v-flex xs3 md3 lg3>
                            <v-card-actions>
                                <v-btn v-if="inc.Estado_id == 1  && can('auditoria.incapacidad.anular')" color="red darken-1" @click="Anular()">Anular</v-btn>
                            </v-card-actions>
                        </v-flex>
                    </v-layout>
                </v-card>
            </v-dialog>
        </v-layout>
        <!-- <div id="app">
	<v-app id="inspire">-->
        <v-layout row>
            <v-flex xs12 md12 lg12>
                <v-timeline v-if="dialog_timeline" style="width:'1200px'">
                    <v-timeline-item v-for="(incapacidad, i) in incapacidades" :key="i" small>
                        <template v-slot:opposite>
                            <span :class="`headline font-weight-bold`" v-text="incapacidad.created_at"></span>
                        </template>
                        <v-card :color="'green'" dark>
                            <v-card-title class="title">{{incapacidad.Nombre}}</v-card-title>
                            <v-card-text class="white text--primary">
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item">
                                        Cédula:
                                        <b>{{incapacidad.Cedula}}</b>
                                    </li>
                                    <li class="list-group-item">
                                        Fecha Nacimiento:
                                        <b>{{incapacidad.Fecha_Naci}}</b>
                                    </li>
                                    <li class="list-group-item">
                                        Edad:
                                        <b>{{incapacidad.Edad_Cumplida}}</b>
                                    </li>
                                    <li class="list-group-item">
                                        Sexo:
                                        <b>{{incapacidad.Sexo}}</b>
                                    </li>
									<li class="list-group-item">
                                        Estado:
                                        <b>{{incapacidad.Estado}}</b>
                                    </li>
                                    <li class="list-group-item">
                                        Atendido por:
                                        <b>{{incapacidad.Medicoordeno}}</b>
                                    </li>
                                </ul>
                                <v-btn :color="'green'" class="mx-0" outline @click="abrirModal(incapacidad)">Ver más..
                                </v-btn>
                            </v-card-text>
                        </v-card>
                    </v-timeline-item>
                </v-timeline>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
	import {
        mapGetters
    } from 'vuex';
    export default {
        data: () => ({
            incapacidades: [],
            incapacidad: {},
            inc: {},
            cedula: "",
            observaciones: "",
            input: null,
            dialog: false,
            dialog_timeline: false,
            nonce: 0,
            pdf: {},
            diagnosticHeaders: [{
                    text: "Marcar Principal",
                    align: "center",
                    value: "marcar"
                },
                {
                    text: "Diagnóstico",
                    align: "center",
                    value: "diagnostico"
                },
                {
                    text: "Tipo Diagnóstico",
                    align: "center",
                    value: "tipo_diagnostico"
                },
                {
                    text: "Marca",
                    align: "center",
                    value: "marca"
                },
                {
                    text: "",
                    align: "center",
                    value: ""
                }
            ],
            Diagnosticos: []
        }),
        computed: {
            ...mapGetters(['can'])
        },
        methods: {
            comment() {
                const time = new Date().toTimeString();
                this.events.push({
                    id: this.nonce++,
                    text: this.input,
                    time: time.replace(
                        /:\d{2}\sGMT-\d{4}\s\((.*)\)/,
                        (match, contents, offset) => {
                            return ` ${contents
			  .split(" ")
			  .map(v => v.charAt(0))
			  .join("")}`;
                        }
                    )
                });
                this.input = null;
            },
            abrirModal(inc) {
                this.fillInc(inc);
                this.dialog = true;
            },
            cerrarModal() {
                this.dialog = false;
                this.observaciones = "";
            },
            fillInc(inc) {
                if (inc.id) {
                    this.inc = inc;
                }
            },
            fillDiagnostic(autorizacion) {
                axios
                    .get("/api/cie10/diagnostico/" + autorizacion.citaPaciente_id)
                    .then(res => {
                        this.Diagnostico = res.data;
                        console.log("Diagnostico", this.Diagnostico);
                    });
            },
            print() {
                if (this.inc) {

                    console.log("inc", this.inc);

                    let pdf = this.getPDFIncap();
                    console.log("pdf", this.pdf);
                    axios
                        .post("/api/pdf/print-pdf", pdf, {
                            responseType: "arraybuffer"
                        })
                        .then(res => {
                            let blob = new Blob([res.data], {
                                type: "application/pdf"
                            });
                            let link = document.createElement("a");
                            link.href = window.URL.createObjectURL(blob);
                            window.open(link.href, "_blank");
                        });
                }
            },
            getPDFIncap() {
                return (this.pdf = {
                    type: "incapacidad",
                    FechaInicio: this.inc.Fechainicio,
                    Nombre: this.inc.Nombre,
                    Edad_Cumplida: this.inc.Edad_Cumplida,
                    Sexo: this.inc.Sexo,
                    medico_ordena: this.inc.Medicoordeno,
                    Celular: this.inc.Celular,
                    Correo: this.inc.Correo,
                    Num_Doc: this.inc.Cedula,
                    cita_paciente_id: this.inc.citaPaciente_id,
                    orden_id: this.inc.Orden_id,
                    dx_principal: this.inc.Diagnostico.substring(0, 4),
                    CantidadDias: this.inc.Dias,
                    FechaFinal: this.inc.Fechafinal,
                    Prorroga: this.inc.Prorroga,
                    TextCie10: this.inc.Diagnostico.substring(0, 4),
                    Contingencia: this.inc.Contingencia,
                    Descripcion: this.inc.Descripcion,
                    Firma: this.inc.Firma
                });
            },
            find() {
                if (!this.cedula) {
                    swal({
                        title: "Debe ingresar un cédula",
                        icon: "warning"
                    });
                    return;
                }

                let inc = {
                    cedula: this.cedula
                };

                axios
                    .post("/api/incapacidad/getIncByCedula", inc)
                    .then(res => {
                        this.incapacidades = res.data;
                        console.log(this.incapacidades);
                        this.dialog_timeline = true;
                    });
            },
            Anular() {

                if (this.observaciones == "") {
                    swal({
                        title: "Debe llenar la Observacion",
                        icon: "warning"
                    });
                    return;
                }

                let obj = {
                	Id: this.inc.id,
                	Nombre: this.inc.Nombre,
                	Inicio: this.inc.Fechainicio,
					Fin: this.inc.Fechafinal,
					Observacion: this.observaciones
				}
				
				axios
                    .post("/api/incapacidad/changeInc", obj)
                    .then(res => {

						swal({
							title: 'Incapacidad',
							text: res.data.message,
							timer: 2000,
							icon: "success",
							buttons: false
						});
						this.cerrarModal();
						this.find();
                    });

            },
        }
    };

</script>

<style lang="scss" scoped>
</style>
