<template>
    <v-container pa-0 fluid grid-list-md>
        <v-layout row wrap>
            <v-dialog v-model="dialog" max-width="1000px">
                <v-card>
                    <v-flex>
                        <v-card flat>
                            <v-card-title class="headline grey lighten-2">Datos del paciente</v-card-title>
                            <v-container>
                                <v-layout wrap align-center>
                                    <v-flex xs4>
                                        <v-text-field v-model="paciente.Primer_Nom" readonly label="Nombre">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs3>
                                        <v-text-field v-model="paciente.Primer_Ape" readonly label="Apellido">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs1>
                                        <v-text-field v-model="paciente.Tipo_Doc" readonly label="Tipo Documento">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs3>
                                        <v-text-field v-model="paciente.Num_Doc" readonly label="Número Documento">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs1>
                                        <v-text-field v-model="paciente.Edad_Cumplida" readonly label="Edad">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs4>
                                        <v-text-field v-model="paciente.Telefono" label="Telefono"></v-text-field>
                                    </v-flex>
                                    <v-flex xs4>
                                        <v-text-field v-model="paciente.Celular1" label="Celular"></v-text-field>
                                    </v-flex>
                                    <v-flex xs4>
                                        <v-text-field v-model="paciente.Celular2" label="Celular 2 (opcional)">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs6>
                                        <v-text-field v-model="paciente.Correo1" label="Correo"></v-text-field>
                                    </v-flex>
                                    <v-flex xs6>
                                        <v-text-field v-model="paciente.Correo2" label="Correo 2 (opcional)">
                                        </v-text-field>
                                    </v-flex>
                                <v-flex xs12 sm6 md6>
                                    <v-select
                                        v-model="data.Actividad"
                                        :items="actividades"
                                        item-text="name"
                                        item-value="name"
                                        label="Actividad"
                                    ></v-select>
                                </v-flex>
                                <v-flex xs12 sm6 md6>
                                    <v-autocomplete
                                        :items="[
                                        'Accidente de Trabajo', 'Atención del parto, del embarazo y posparto', 'Atención del recién nacido',
                                        'Atención planificación familiar', 'Atención crecimiento y desarrollo',
                                        'Atención joven Sano', 'Detención alteraciones del embarazo',
                                        'Detección alteraciones del adulto', 'Detención alteraciones agudeza Visual',
                                        'Enfermedad Profesional', 'Enfermedad General', 'Evento Catastrofico', 'Lesión por Agresión', 'No aplica',
                                        'Otro Tipo de Accidente', 'Sospecha de Maltrato'
                                        ]"
                                        label="Finalidad"
                                        append-icon="search"
                                        v-model="data.Finalidad"
                                    ></v-autocomplete>
                                </v-flex>
                                </v-layout>
                            </v-container>
                            <v-container>
                                <v-btn color="blue" class="ma-2 white--text" @click="generate()">
                                    Atender
                                    <v-icon right dark>send</v-icon>
                                </v-btn>
                            </v-container>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" flat @click="cerrarModal()">Cerrar</v-btn>
                        </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-card>
            </v-dialog>
            <v-flex xs9>
                <template>
                    <div>
                        <v-toolbar flat color="white">
                            <v-toolbar-title>Mi agenda</v-toolbar-title>
                            <v-divider class="mx-2" inset vertical></v-divider>
                            <v-toolbar-title>Fecha</v-toolbar-title>
                            <v-divider class="mx-2" inset vertical></v-divider>
                            <v-spacer></v-spacer>
                        </v-toolbar>
                        <v-data-table :headers="headers" :items="citas" class="elevation-1"
                            :rows-per-page-items="[{'value':-1}]">
                            <template v-slot:items="props">
                                <td>{{ props.item.Hora_Inicio | time }}</td>
                                <td class="text-xs-right">
                                    {{ props.item.Primer_Nom }} {{ props.item.SegundoNom }}
                                    {{ props.item.Primer_Ape }} {{ props.item.Segundo_Ape }}
                                </td>
                                <td class="text-xs-right">{{ props.item.Num_Doc }}</td>
                                <td class="text-xs-right">{{ props.item.Edad_Cumplida }}</td>
                                <td class="text-xs-right">{{ props.item.Tipo_agenda }}</td>
                                <td class="text-xs-right">{{ props.item.Estado }}</td>
                                <td class="justify-center layout px-0">
                                    <v-tooltip top>
                                        <template v-slot:activator="{ on }">
                                            <v-btn text v-if="props.item.CP_Estado_id == 4"
                                                :disabled="disable(props.item)" icon color="green" dark v-on="on">
                                                <v-icon @click="atenderPaciente(props.item)">how_to_reg</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>Atender</span>
                                    </v-tooltip>
                                    <v-tooltip top>
                                        <template v-slot:activator="{ on }">
                                            <v-btn text v-if="props.item.CP_Estado_id == 8"
                                                :disabled="disable(props.item)" icon color="orange" dark v-on="on">
                                                <v-icon @click="reditectToAtender(props.item)">how_to_reg</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>Regresar</span>
                                    </v-tooltip>
                                    <v-tooltip top>
                                        <template v-slot:activator="{ on }">
                                            <v-btn text icon color="blue" dark v-on="on">
                                                <v-icon @click="printhc(props.item)">assignment_turned_in</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>Historial</span>
                                    </v-tooltip>
                                    <v-tooltip top>
                                        <template v-slot:activator="{ on }">
                                            <v-btn text v-if="props.item.CP_Estado_id == 4"
                                                :disabled="disable(props.item)" icon color="red" dark v-on="on">
                                                <v-icon @click="inasistioPaciente(props.item)">person_add_disabled
                                                </v-icon>
                                            </v-btn>
                                        </template>
                                        <span>Inasistida</span>
                                    </v-tooltip>
                                </td>
                            </template>
                            <template v-slot:no-data>
                                <!-- <v-btn color="primary" @click="initialize">Reset</v-btn> -->
                            </template>
                        </v-data-table>
                    </div>
                </template>
                <template v-if="notProgramed.length > 0">
                    <div>
                        <v-toolbar flat color="white">
                            <v-toolbar-title>Citas no programadas</v-toolbar-title>
                            <v-divider class="mx-2" inset vertical></v-divider>
                            <v-spacer></v-spacer>
                        </v-toolbar>
                        <v-data-table :headers="headersNotProgramed" :items="notProgramed" class="elevation-1"
                            :rows-per-page-items="[{'value':-1}]">
                            <template v-slot:items="props">
                                <td>{{ props.item.Fecha }}</td>
                                <td>{{ props.item.Tipo_cita }}</td>
                                <td class="text-xs-right">
                                    {{ props.item.Primer_Nom }} {{ props.item.SegundoNom }}
                                    {{ props.item.Primer_Ape }} {{ props.item.Segundo_Ape }}
                                </td>
                                <td class="text-xs-right">{{ props.item.Num_Doc }}</td>
                                <td class="text-xs-right">{{ props.item.Edad_Cumplida }}</td>
                                <td class="text-xs-right">{{ props.item.Estado }}</td>
                                <td class="justify-center layout px-0">
                                    <v-tooltip top>
                                        <template v-slot:activator="{ on }">
                                            <v-btn text v-if="props.item.CP_Estado_id == 8"
                                                :disabled="disable(props.item)" icon color="orange" dark v-on="on">
                                                <v-icon @click="reditectToAtender(props.item)">how_to_reg</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>Regresar</span>
                                    </v-tooltip>
                                    <v-tooltip top>
                                        <template v-slot:activator="{ on }">
                                            <v-btn text icon color="blue" dark v-on="on">
                                                <v-icon @click="printhc(props.item)">assignment_turned_in</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>Historial</span>
                                    </v-tooltip>
                                </td>
                            </template>
                            <template v-slot:no-data>
                                <!-- <v-btn color="primary" @click="initialize">Reset</v-btn> -->
                            </template>
                        </v-data-table>
                    </div>
                </template>
            </v-flex>
            <v-flex xs3>
                <v-card max-height="100%" class="mb-3" v-if="can('medico.no-programada.enter')" >
                    <v-card-title>
                        <span class="title layout justify-center font-weight-light">Buscar Paciente cita no programada</span>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-container grid-list-md fluid class="pa-0">
                            <v-layout wrap align-center justify-center>
                                <v-flex xs12>
                                    <v-form @submit.prevent="search_paciente()">
                                        <v-layout row wrap>
                                            <v-flex xs10>
                                                <v-text-field v-model="cedula_paciente" label="Número de Documento"></v-text-field>
                                            </v-flex>
                                            <v-flex xs2>
                                                <v-btn @click="search_paciente()" @keyup.enter="search_paciente()"
                                                    v-if="!paciente.id" fab outline small color="success">
                                                    <v-icon>search</v-icon>
                                                </v-btn>
                                                <v-btn @click="clearFields()" v-if="paciente.id" fab outline small
                                                    color="error">
                                                    <v-icon>clear</v-icon>
                                                </v-btn>
                                            </v-flex>
                                        </v-layout>
                                    </v-form>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
    // import { EventBus } from "../../event-bus.js";
    import moment from "moment";
    import { mapGetters } from 'vuex';
    export default {
        name: "Medico",
        data() {
            return {
                citas: [],
                notProgramed: [],
                cita: "",
                citaPaciente: {},
                type: {
                    type: "Ingreso"
                },
                citaPacienteId: "0",
                cita_paciente_id: '',
                cedula_paciente: '',
                actividades: [],
                paciente: {},
                dialog: false,
                data: {
                    entidademite: "Sumimedical",
                    Finalidad: "",
                    Actividad: '',
                    Tipocita_id: 2
                },
                headersNotProgramed: [
                    {
                        text: "Fecha",
                        value: "Fecha",
                        align: "center",
                        sortable: true
                    },
                    {
                        text: "Tipo Cita",
                        //value: "Fecha",
                        align: "center",
                        sortable: true
                    },
                    {
                        text: "Paciente",
                        value: "Primer_Nom",
                        align: "center"
                    },
                    {
                        text: "Cédula",
                        value: "Num_Doc",
                        align: "center"
                    },
                    {
                        text: "Edad",
                        value: "Edad_Cumplida",
                        align: "center"
                    },
                    {
                        text: "Estado",
                        value: "CP_Estado_id",
                        align: "center"
                    },
                    {
                        text: "Acciones",
                        value: "",
                        align: "center"
                    }
                ],
                headers: [{
                        text: "Hora",
                        value: "Hora_Inicio",
                        align: "center",
                        sortable: true
                    },
                    {
                        text: "Paciente",
                        value: "Primer_Nom",
                        align: "center"
                    },
                    {
                        text: "Cédula",
                        value: "Num_Doc",
                        align: "center"
                    },
                    {
                        text: "Edad",
                        value: "Edad_Cumplida",
                        align: "center"
                    },
                    {
                        text: "Tipo Cita",
                        value: "Tipo_Cita",
                        align: "center"
                    },
                    {
                        text: "Estado",
                        value: "CP_Estado_id",
                        align: "center"
                    },
                    {
                        text: "Acciones",
                        value: "",
                        align: "center"
                    }
                ]
            };
        },
        filters: {
            time: time => {
                moment.locale("es");
                return moment(time).format("HH:mm:ss");
            }
        },
        mounted() {
            this.cronogramacitashoy();
            this.getNotProgramed();
        },
        computed: {
            ...mapGetters(['can'])
        },
        methods: {
            printhc(cita) {
                console.log("cita", cita);
                let cc = {
                    Num_Doc: cita.Num_Doc
                };
                axios.post("/api/historiapaciente/gethistoria", cc).then(res => {
                    this.historiapaciente = res.data.find(h => h.id == cita.cita_paciente_id);
                    console.log("res", res.data);
                    if (!this.historiapaciente) {
                        swal({
                            title: "Historial",
                            text: "El historial no puede ser mostrado",
                            timer: 2000,
                            icon: "error",
                            buttons: false
                        });
                    } else {

                        let especialidad = '';
                        let hora = '';

                        (cita.Especialidad) ? especialidad = cita.Especialidad : especialidad = this.data.Actividad;
                        (cita.Hora_Inicio) ? hora = cita.Especialidad : hora = cita.Fecha;

                        let pdf = {
                            type: "test",
                            FechaInicio: hora,
                            Especialidad: especialidad,
                            Nombre: this.historiapaciente.Nombre,
                            Edad_Cumplida: this.historiapaciente.Edad,
                            Sexo: this.historiapaciente.Sexo,
                            Antropometricas: this.historiapaciente.Antropometricas,
                            Atendido_Por: this.historiapaciente.Atendido_Por,
                            Cardiovascular: this.historiapaciente.Cardiovascular,
                            telefono: this.historiapaciente.Celular,
                            Condiciongeneral: this.historiapaciente.Condiciongeneral,
                            Cédula: this.historiapaciente.Cédula,
                            Datetimeingreso: this.historiapaciente.Datetimeingreso,
                            Datetimesalida: this.historiapaciente.Datetimesalida,
                            Departamento: this.historiapaciente.Departamento,
                            Destinopaciente: this.historiapaciente.Destinopaciente,
                            Diagnostico_Principal: this.historiapaciente
                                .Diagnostico_Principal,
                            Diagnostico_Secundario: this.historiapaciente
                                .Diagnostico_Secundario,
                            Direccion_Residencia: this.historiapaciente.Direccion_Residencia,
                            Edad: this.historiapaciente.Edad,
                            Endocrinologico: this.historiapaciente.Endocrinologico,
                            Enfermedadactual: this.historiapaciente.Enfermedadactual,
                            Entidademite: this.historiapaciente.Entidademite,
                            Fecha_Nacimiento: this.historiapaciente.Fecha_Nacimiento,
                            Fecha_solicita: this.historiapaciente.Fecha_solicita,
                            Finalidad: this.historiapaciente.Finalidad,
                            Gastrointestinal: this.historiapaciente.Gastrointestinal,
                            Genitourinario: this.historiapaciente.Genitourinario,
                            Laboraen: this.historiapaciente.Laboraen,
                            Linfatico: this.historiapaciente.Linfatico,
                            Medicoordeno: this.historiapaciente.Medicoordeno,
                            Motivoconsulta: this.historiapaciente.Motivoconsulta,
                            Municipio_Afiliado: this.historiapaciente.Municipio_Afiliado,
                            Neurologico: this.historiapaciente.Neurologico,
                            Nombre: this.historiapaciente.Nombre,
                            Norefiere: this.historiapaciente.Norefiere,
                            Observaciones: this.historiapaciente.Observaciones,
                            Oftalmologico: this.historiapaciente.Oftalmologico,
                            Osteomioarticular: this.historiapaciente.Osteomioarticular,
                            Osteomuscular: this.historiapaciente.Osteomuscular,
                            Otorrinoralingologico: this.historiapaciente
                                .Otorrinoralingologico,
                            Otros_Signos_Vitales: this.historiapaciente.Otros_Signos_Vitales,
                            Planmanejo: this.historiapaciente.Planmanejo,
                            Presión_Arterial: this.historiapaciente.Presión_Arterial,
                            Recomendaciones: this.historiapaciente.Recomendaciones,
                            Respiratorio: this.historiapaciente.Respiratorio,
                            Resultayudadiagnostica: this.historiapaciente
                                .Resultayudadiagnostica,
                            Sexo: this.historiapaciente.Sexo,
                            Signos_Vitales: this.historiapaciente.Signos_Vitales,
                            Tegumentario: this.historiapaciente.Tegumentario,
                            Telefono: this.historiapaciente.Telefono,
                            Timeconsulta: this.historiapaciente.Timeconsulta,
                            tipo_afiliado: this.historiapaciente.Tipo_Afiliado,
                            Tipo_Orden: this.historiapaciente.Tipo_Orden,
                            Tipodiagnostico: this.historiapaciente.Tipodiagnostico,
                            Antecedentes: this.historiapaciente.Antecedentes,
                            Abdomen: this.historiapaciente.Abdomen,
                            Agudezavisual: this.historiapaciente.Agudezavisual,
                            Cabezacuello: this.historiapaciente.Cabezacuello,
                            Cardiopulmonar: this.historiapaciente.Cardiopulmonar,
                            Examenmama: this.historiapaciente.Examenmama,
                            Examenmental: this.historiapaciente.Examenmental,
                            Extremidades: this.historiapaciente.Extremidades,
                            Frecucardiaca: this.historiapaciente.Frecucardiaca,
                            Frecurespiratoria: this.historiapaciente.Frecurespiratoria,
                            Genitourinario: this.historiapaciente.Genitourinario,
                            Pulsosperifericos: this.historiapaciente.Pulsosperifericos,
                            Ojosfondojos: this.historiapaciente.Ojosfondojos,
                            Osteomuscular: this.historiapaciente.Osteomuscular,
                            Pielfraneras: this.historiapaciente.Pielfraneras,
                            Reflejososteotendinos: this.historiapaciente.Reflejososteotendinos,
                            Tactoretal: this.historiapaciente.Tactoretal,
                            Dietasaludable: this.historiapaciente.Dietasaludable,
                            Suenoreparador: this.historiapaciente.Suenoreparador,
                            Duermemenoseishoras: this.historiapaciente.Duermemenoseishoras,
                            Altonivelestres: this.historiapaciente.Altonivelestres,
                            Actividadfisica: this.historiapaciente.Actividadfisica,
                            Frecuenciasemana: this.historiapaciente.Frecuenciasemana,
                            Duracion: this.historiapaciente.Duracion,
                            Fumacantidad: this.historiapaciente.Fumacantidad,
                            Fumainicio: this.historiapaciente.Fumainicio,
                            Fumadorpasivo: this.historiapaciente.Fumadorpasivo,
                            Cantidadlicor: this.historiapaciente.Cantidadlicor,
                            Licorfrecuencia: this.historiapaciente.Licorfrecuencia,
                            Consumopsicoactivo: this.historiapaciente.Consumopsicoactivo,
                            Psicoactivocantidad: this.historiapaciente.Psicoactivocantidad,
                            Estilovidaobservaciones: this.historiapaciente.Estilovidaobservaciones,
                            id: this.historiapaciente.id,
                            Firma: this.historiapaciente.Firma
                        };
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
                });
            },

            cronogramacitashoy() {
                axios.get("/api/cita/cronogramahoy").then(res => {
                    res.data.forEach(cita => {
                        if (cita.cita_paciente_id) {
                            this.citas.push(cita);
                        }
                    });
                    // let status = this.citas.find(c => c.CP_Estado_id == 8);
                    // if (status) {
                    //     this.citaPacienteId = 1;
                    // }
                });
            },
            inasistioPaciente(cita) {
                swal({
                    title: "¿Está Seguro(a)?",
                    text: "Se cancela la cita por inasistencia!",
                    icon: "warning",
                    buttons: ["Cancelar", "Confirmar"],
                    dangerMode: true
                }).then(willDelete => {
                    axios.put(`/api/cita/inasistio/${cita.id}`, cita).then(res => {
                        console.log(res);
                        this.$router.go();
                    });
                });
            },
            atenderPaciente(cita) {
                this.cita_paciente_id = cita.cita_paciente_id;
                this.num_doc = cita.Num_Doc;
                swal({
                    title: "¿Está Seguro(a)?",
                    text: "Se iniciará la atención al paciente!",
                    icon: "info",
                    buttons: ["Cancelar", "Confirmar"],
                    dangerMode: true
                }).then(willDelete => {
                    if (willDelete) {
                        // axios
                        //     .post("/api/cita/" + this.cita_paciente_id + "/atender")
                        //     .then(res => console.log(res));
                        // axios
                        //     .post("/api/cita/" + this.cita_paciente_id + "/setTime", this.type)
                        //     .then(res => console.log(res));
                        // // let cita = this.citas.find(
                        // //     c => c.cita_paciente_id == this.cita_paciente_id
                        // // );
                        // axios
                        //     .put(`/api/cita/update-state-consulta/${this.cita_paciente_id}`)
                        //     .then(res => console.log(res));

                        // localStorage.setItem("PacienteCedula", this.num_doc);

                        // this.$router.push(
                        //     "/historiaclinica?cita_paciente=" + this.cita_paciente_id
                        // );

                        this.atenderSetTime(this.cita_paciente_id, this.num_doc);
                    }
                });
            },
            disable(cita) {
                // if (this.citaPacienteId != 0) {
                //   if (cita.CP_Estado_id == 8) {
                //     return false;
                //   } else {
                //     return true;
                //   }
                // } else {
                if (cita.CP_Estado_id == 9 || cita.CP_Estado_id == 12) {
                    return true;
                } else {
                    return false;
                }
                // }
            },
            reditectToAtender(cita) {
                localStorage.setItem("PacienteCedula", cita.Num_Doc);
                this.$router.push("/historiaclinica?cita_paciente=" + cita.cita_paciente_id);
            },
            search_paciente() {
                if (!this.cedula_paciente) return;

                axios.get(`/api/paciente/showEnabled/${this.cedula_paciente}`)
                    .then((res) => {
                        if (res.data.paciente) {
                            this.paciente = res.data.paciente;
                            this.dialog = true;
                        }
                        if (res.data.message) this.showMessage(res.data.message);
                    });
			},
			cerrarModal() {
                this.dialog = false;
                this.cedula_paciente = '';
                this.paciente = {};
                this.data.Finalidad = '';
                this.data.Actividad = '';
			},
            generate() {
                if (!this.data.entidademite ) {
                    swal({
                        title: "Consulta no programada",
                        text: "Es necesario añadir una entidad emisora!",
                        timer: 2000,
                        icon: "error",
                        buttons: false
                    });
                    return;
                }
                if (!this.data.Finalidad ) {
                    swal({
                        title: "Consulta no programada",
                        text: "Es necesario seleccionar una finalidad!",
                        timer: 2000,
                        icon: "error",
                        buttons: false
                    });
                    return;
                }
                swal({
                    title: "¿Está Seguro(a)?",
                    text: "Se realizará la creación de la orden!",
                    type: "success",
                    icon: "info",
                    buttons: ["Cancelar", "Confirmar"],
                    dangerMode: true
                }).then(async willDelete => {
                    if (willDelete) {
                        await axios
                            .post(
                                `/api/cita/create_cita_paciente/${this.paciente.id}`,
                                this.data
                            ).then(async res => {
                                let citaPaciente = res.data;
                                this.atenderSetTime(citaPaciente.id, this.paciente.Num_Doc);
                            });
                    }
                });
            },
            atenderSetTime(cita_paciente_id, num_doc){

                if (cita_paciente_id && num_doc){
                    axios
                        .post("/api/cita/" + cita_paciente_id + "/atender")
                        .then(res => console.log(res));
                    axios
                        .post("/api/cita/" + cita_paciente_id + "/setTime", this.type)
                        .then(res => console.log(res));
                    axios
                        .put(`/api/cita/update-state-consulta/${cita_paciente_id}`)
                        .then(res => console.log(res));

                    localStorage.setItem("PacienteCedula", num_doc);

                    this.$router.push(
                        "/historiaclinica?cita_paciente=" + cita_paciente_id
                    );
                }
            },
            getNotProgramed() {
                axios.get("/api/cita/notProgramed").then(res => {
                    res.data.notProgramed.forEach(cita => {
                        if (cita.cita_paciente_id) {
                            this.notProgramed.push(cita);
                        }
                    });
                    this.actividades = res.data.activities;
                    console.log("actividades", this. actividades);
                });
            },
            showMessage(message){
                swal({
                    title: `${message}`,
                    icon: "warning",
                });
            },
        }
    };

</script>
