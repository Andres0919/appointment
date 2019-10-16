<template>
    <div>
        <v-layout justify-center wrap>
            <v-dialog v-model="dialogOpen" fullscreen hide-overlay transition="dialog-bottom-transition" persistent scrollable>
                <v-card tile>
                    <v-toolbar flat dark color="primary">
                        <v-btn icon dark @click="closeDialog()">
                            <v-icon>close</v-icon>
                        </v-btn>
                        <v-toolbar-title>{{nameDialog}}</v-toolbar-title>
                        <v-spacer></v-spacer>
                    </v-toolbar>
                    <v-card-text>
                        <HistorialExamenes v-if="'HistorialExamenes' == nameDialog"></HistorialExamenes>
                        <HistorialConsulta v-if="'Historial Consulta' == nameDialog"></HistorialConsulta>
                        <HistorialMedicamentos v-if="'HistorialMedicamentos' == nameDialog"></HistorialMedicamentos>
                        <Ordenamiento :paciente="paciente" v-if="'Ordenamiento' == nameDialog"></Ordenamiento>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </v-layout>
    </div>
</template>

<script>
    import HistorialExamenes from "./HistorialExamenes";
    import HistorialConsulta from "./HistoriaConsulta";
    import HistorialMedicamentos from "./HistorialMedicamentos";
    import Ordenamiento from "./Ordenamiento";
    import {
        EventBus
    } from "../../event-bus.js";

    export default {
        name: "Dialogs",
        components: {
            HistorialExamenes,
            HistorialConsulta,
            HistorialMedicamentos,
            Ordenamiento
        },
        props: {
            dialogOpen: {
                type: Boolean,
                default: false
            },
            nameDialog: {
                type: String,
                default: false
            },
            paciente: {
                type: Object,
                default: null
            }
        },
        methods: {
            closeDialog() {
                EventBus.$emit("close-dialog");
                this.path = this.$route.path;
                this.cita_paciente_id = localStorage.getItem("citapaciente_id");
                if (this.path == "/transcripcion") {
                    axios
                        .put(`/api/cita/update-state-atendida/${this.cita_paciente_id}`)
                        .then(res => {
                            localStorage.removeItem("PacienteCedula");
                            localStorage.removeItem("citapaciente_id");
                            localStorage.removeItem("Diagnostico");
                            EventBus.$emit("disable-layout-hc");
                            this.$router.push("/transcripcion");
                        }).catch(err => console.log(err.response.data));
                }
            }
        }
    };

</script>
