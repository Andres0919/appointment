<template>
    <v-layout row wrap>
        <v-flex xs12>
            <v-stepper v-model="e6" vertical>
                <v-stepper-step :complete="e6 > 1" editable :edit-icon="$vuetify.icons.complete" step="1">DIAGNÓSTICOS
                </v-stepper-step>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12 sm6>
                            <v-autocomplete v-model="Cie10_id" append-icon="search" :items="cieConcat"
                                item-disabled="customDisabled" item-text="nombre" item-value="id" label="Diagnóstico">
                            </v-autocomplete>
                        </v-flex>
                        <v-flex xs12 sm6>
                            <v-select :items="['Impresión diagnóstica', 'Confirmado nuevo','Confirmado repetido']"
                                label="Tipo Diagnóstico" v-model="Tipodiagnostico" chips></v-select>
                        </v-flex>
                        <v-flex xs12 sm6>
                            <v-autocomplete v-if="Tipodiagnostico != 'Impresión diagnóstica' && Tipodiagnostico" :items="['Oncológicos','Anticoagulados','Salud Mental','Nefroprotección ','Respiratorios',
						'Reumatologicos','Tramisibles Crónicas','Gestantes','Enfermedades Huerfanas','Trasplantados',
						'Polimedicados','Pacientes Tutela','Paciente Alto Costo','Domiciliario','Primera Infancia','Infancia ',
						'Adolescencia ','Juventud ','Riesgo Cardiovascular','Grupal Curso Psicoprofilactico',
						'Apoyo Lactancia Materna ','Detección Temprana Cáncer Cuello Uterino ','Riesgo Cardiovascular',
						'Planificación Familiar','Atención Preconcepcional','Promocion De Alimentacion Y Nutricion','Prenatal',
						'Atención Del Posparto','Atención Del Recien Nacido','Detección Temprana Cancer De Mama', 'Adultez', 'Vejez'
						]" label="Marcar paciente" v-model="Marcapaciente" attach multiple chips></v-autocomplete>
                        </v-flex>
                    </v-layout>
                </v-container>

                <v-btn color="primary" round dark v-on:click="addDiagnostico()">Ingresar Diagnóstico</v-btn>

                <v-data-table :headers="headers" :items="Diagnostico" :search="search">
                    <template v-slot:items="props">
                        <tr :active="props.selected" @click="props.selected = !props.selected">
                            <td>
                                <v-checkbox color="primary" v-model="selectedItems" hide-details :value="props.item">
                                </v-checkbox>
                            </td>
                            <td>{{ props.item.Codigo }}</td>
                            <td class="text-xs-center">{{ props.item.Tipodiagnostico }}</td>
                            <td class="text-xs-center">
                                <v-select :items="props.item.Marcapaciente" label="Marcar paciente"
                                    v-model="props.item.Marcapaciente" attach multiple chips></v-select>
                            </td>
                            <td class="text-xs-center">
                                <v-btn fab utline color="error" small @click="removeDiagnostico(props)">
                                    <v-icon>clear</v-icon>
                                </v-btn>
                            </td>
                        </tr>
                    </template>
                    <v-alert v-slot:no-results :value="true" color="error" icon="warning">Your search for "{{ search }}"
                        found no results.</v-alert>
                </v-data-table>

                <v-btn color="success" round dark v-on:click="submit()">Aceptar</v-btn>
            </v-stepper>
        </v-flex>
    </v-layout>
</template>
<script>
    import {
        EventBus
    } from "../../../event-bus.js";
    export default {
        created() {
            this.citaPaciente.id = this.$route.query.cita_paciente;
        },
        data() {
            return {
                dialog: false,
                cie10s: [],
                cie10Array: [],
                citaPaciente: {
                    id: ""
                },
                search: "",
                Cie10_id: "",
                Codigo: "",
                Tipodiagnostico: "",
                Marcapaciente: [],
                Diagnostico: [],
                DiagnosticoSaved: [],
                data: {
                    Numfacturazeus: "",
                    Numfactura: "",
                    Tipotransacion_id: "1",
                    BodegaOrigen_id: "",
                    Reps_id: "",
                    BodegaDestino_id: "",
                    bodegarticulos: []
                },
                selectedItems: {},
                e6: 1,
                antecedentesRCVM: [
                    "Hipertension Arterial",
                    "Dislipidemia",
                    "Diabetes Mellitus",
                    "Enfermedad Cardiovascular"
                ],
                headers: [{
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
                ]
            };
        },
        computed: {
            cieConcat() {
                return this.cie10Array = this.cie10s.map(cie => {
                    return {
                        id: cie.id,
                        codigo: cie.Codigo_CIE10,
                        nombre: `${cie.Codigo_CIE10} - ${cie.Descripcion}`,
                        customDisabled: false
                    };
                });
            }
        },
        mounted() {
            this.fetchCie10s();
            this.getLocalStorage();
        },
        methods: {
            addDiagnostico() {

                if (this.Cie10_id) {
                    this.cie10Array.find(cie10 => {
                        if (cie10.id == this.Cie10_id) {
                            this.Codigo = cie10.codigo;
                            // this.Diagnostico[i].Codigo = cie10.codigo;
                        }
                    });
                }

                if (
                    this.Cie10_id &&
                    this.Tipodiagnostico != "Impresión diagnóstica" &&
                    this.Marcapaciente.length > 0
                ) {
                    this.Diagnostico.push({
                        Cie10_id: this.Cie10_id,
                        Tipodiagnostico: this.Tipodiagnostico,
                        Marcapaciente: this.Marcapaciente,
                        Esprimario: false,
                        Codigo: this.Codigo
                    });
                    this.disable(this.Cie10_id);
                    this.clearDataArticulo();
                } else if (
                    this.Cie10_id &&
                    this.Tipodiagnostico == "Impresión diagnóstica" &&
                    this.Marcapaciente.length == 0
                ) {
                    this.Diagnostico.push({
                        Cie10_id: this.Cie10_id,
                        Tipodiagnostico: this.Tipodiagnostico,
                        Esprimario: false,
                        Codigo: this.Codigo
                    });
                    this.disable(this.Cie10_id);
                    this.clearDataArticulo();
                }
            },
            clearDataArticulo() {
                this.Cie10_id = "";
                this.Tipodiagnostico = "";
                this.Marcapaciente = "";
                this.Codigo = "";
            },
            removeDiagnostico(diagnostico) {
                this.Diagnostico.splice(diagnostico.index, 1);
				if (diagnostico.item.id != null) {
					axios
						.get(`/api/cie10/deleteDiagnostic/${diagnostico.item.id}`)
						.then(res => localStorage.removeItem("Diagnostico"));
				}
                this.cie10Array.map(cie10 => {
                    if (cie10.id == diagnostico.item.Cie10_id) {
                        cie10.customDisabled = false
                    }
                });
            },
            submit() {
                if (this.Diagnostico.length == 0 || !this.selectedItems) {
                    swal({
                        title: "Debe asignar un diagnostico principal",
                        icon: "warning"
                    });
                    return;
                }

                var diag = [];

                this.Diagnostico.forEach(diagnostico => {
                    if (diagnostico.Cie10_id == this.selectedItems.Cie10_id) {
                        diagnostico.Esprimario = true;
                    }

                    if (diagnostico.id == null) {
                        diag.push(diagnostico);
                    }

                });

                swal({
                    title: "¿Está Seguro(a)?",
                    text: "El diagnóstico será almacenado",
                    icon: "warning",
                    buttons: ["Cancelar", "Confirmar"],
                    dangerMode: true
                }).then(willDelete => {
                    if (willDelete) {
                        axios
                            .post(`/api/cie10/create/${this.citaPaciente.id}`, diag)
                            .then(res => {
                                localStorage.setItem(
                                    "Diagnostico",
                                    JSON.stringify(this.Diagnostico)
                                );
                                axios
                                    .get(
                                        "/api/pacienteantecedente/antecedentes/" +
                                        this.citaPaciente.id +
                                        ""
                                    )
                                    .then(res => {
                                        let addRCVM = false;
                                        res.data.forEach(dat => {
                                            // console.log(this.antecedentesRCVM)
                                            // console.log(dat)
                                            // console.log(dat.Nombre)
                                            if (this.antecedentesRCVM.includes(dat.Nombre)) {
                                                addRCVM = true;
                                            }
                                        });

                                        if (addRCVM) {
                                            this.$router.push(
                                                "/historiaclinica/rcvm?cita_paciente=" +
                                                this.citaPaciente.id
                                            );
                                        } else {
                                            this.$router.push(
                                                "/historiaclinica/conducta?cita_paciente=" +
                                                this.citaPaciente.id
                                            );
                                            EventBus.$emit(
                                                "change_disabled_list_history",
                                                "DIAGNOSTICOS"
                                            );
                                            // console.log(res.data);
                                            // swal("¡Diagnóstico almacenado con exito!", {
                                            //   timer: 2000,
                                            //   icon: "success",
                                            //   buttons: false
                                            // });
                                        }
                                    });
                            })
                            .catch(err => console.log(err.response.data));
                    }
                });
            },
            fetchCie10s() {
                axios.get("/api/cie10/all").then(res => {
                    this.cie10s = res.data;
                    console.log(this.cie10s);
                });
            },
            getLocalStorage() {
                let Diagnostico = JSON.parse(localStorage.getItem("Diagnostico"));
                if (Diagnostico) {
                    this.Diagnostico = Diagnostico;
                    this.Diagnostico.forEach(diag => {
                        this.disable(diag.Cie10_id);
                    });
                } else {
                    this.fetchDiagnostico();
                }
            },
            fetchDiagnostico() {
                axios.get(`/api/cie10/diagnostico/${this.citaPaciente.id}`).then(res => {
                    this.DiagnosticoSaved = res.data.cie10;
                    this.Diagnostico = this.DiagnosticoSaved;
                });
            },
            disable(id) {
                // let i = this.Diagnostico.length - 1;
                this.cie10Array.map(cie10 => {
                    if (cie10.id == id) {
                        cie10.customDisabled = true
                        // this.Diagnostico[i].Codigo = cie10.codigo;
                    }
                });
            }
        }
    };

</script>
<style scoped>
</style>
