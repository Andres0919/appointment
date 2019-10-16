<template>
    <v-flex xs12>
        <v-dialog v-model="dialog" max-width="700px">
            <v-card>
                <v-card-title>
                    <span class="headline">Poner en espera</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-textarea name="input-7-1" label="Observacion" value v-model="observaciones"></v-textarea>
                        <v-btn color="blue" class="ma-2 white--text" @click="enviar()">
                            Enviar 
                            <v-icon right dark>send</v-icon>
                        </v-btn>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click="cerrarModal()">Cerrar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-card>
            <v-card-title primary-title>
                <v-layout>
                    <v-flex>
                        <span class="body-1 font-weight-black">Nombre:</span>
                        {{paciente.Primer_Nom}}&nbsp;{{paciente.SegundoNom}} {{paciente.Primer_Ape}}
                        {{paciente.Segundo_Ape}}
                    </v-flex>
                    <v-flex>
                        <span class="body-1 font-weight-black">Cédula:</span>
                        {{paciente.Num_Doc}}&nbsp;
                    </v-flex>
                    <v-flex>
                        <span class="body-1 font-weight-black">Edad:</span>
                        {{paciente.Edad_Cumplida}}&nbsp; &nbsp;
                    </v-flex>
                    <v-flex>
                        <span class="body-1 font-weight-black">Sexo:</span>
                        {{paciente.Sexo}}&nbsp; &nbsp;
                    </v-flex>
                    <v-flex>
                        <v-icon color="green darken-2">mdi-star-circle</v-icon>
                    </v-flex>
                    <v-flex>
                        <v-icon color="orange darken-2">mdi-folder-multiple</v-icon>
                    </v-flex>
                    <v-flex>
                        <v-icon right color="gray darken-2">mdi-clock</v-icon>&nbsp;
                        <span>{{ time }}</span>
                    </v-flex>
                </v-layout>
                <v-btn color="primary" type="button" @click="dialog = true">Poner en espera</v-btn>
                <v-btn color="success" type="button" @click="close_and_save()">Guardar y Finalizar</v-btn>
            </v-card-title>
        </v-card>
    </v-flex>
</template>

<script>
    import {
        EventBus
    } from "../../event-bus.js";
    import {
        setTimeout,
        setInterval
    } from "timers";
    import moment from "moment";
    export default {
        name: "Hclinica",
        created() {
            this.cita_paciente_id = this.$route.query.cita_paciente;
        },
        data() {
            return {
                Fecha_hora_ingreso: "",
                time: "",
                cita_paciente_id: "",
                cronos: "",
                observaciones: "",
                dialog: false,
                type: {
                    type: "Salida"
                }
            };
        },
        props: {
            paciente: {
                type: Object,
                default: null
            }
        },
        computed: {
            infopaciente() {
                return this.$store.state.Hclinica;
            }
        },
        mounted() {
            if (this.cita_paciente_id) {
                this.getTime();
            }
        },
        methods: {
            getTime() {
                axios
                    .post("/api/cita/" + this.cita_paciente_id + "/getTime")
                    .then(res => {
                        this.Fecha_hora_ingreso = res.data;
                        this.cronometro();
                    });
            },
            close_and_save() {
                swal({
                    title: "¿Está Seguro(a)?",
                    text: "Una vez el finalizada la cita se deshabilitará, ya no podrá ingresar!",
                    icon: "info",
                    buttons: ["Cancelar", "Confirmar"],
                    dangerMode: true
                }).then(willDelete => {
                    if (willDelete) {

                        if (!this.cita_paciente_id) {
                            this.cita_paciente_id = localStorage.getItem("citapaciente_id");
                        }

                        axios
                            .post("/api/cita/" + this.cita_paciente_id + "/setTime", this.type)
                            .then(res => {
                                clearInterval(this.cronos._id);
                                axios
                                    .put(`/api/cita/update-state-atendida/${this.cita_paciente_id}`)
                                    .then(res => {
                                        console.log(res);
                                        localStorage.removeItem("Gineco");
                                        localStorage.removeItem("Diagnostico");
                                        localStorage.removeItem("ExamenSistema");
                                        localStorage.removeItem("MotivoConsulta");
                                        localStorage.removeItem("AntecedentesPersonales");
                                        localStorage.removeItem("AntecedentesFamiliares");
                                        localStorage.removeItem("rcvm");
                                        localStorage.removeItem("EstiloVida");
                                        localStorage.removeItem("Conducta");
                                        localStorage.removeItem("PacienteCedula");
                                        localStorage.removeItem("citapaciente_id");
                                        swal("¡Cita finalizada!", {
                                            timer: 2000,
                                            icon: "success",
                                            buttons: false
                                        });
                                        EventBus.$emit("disable-layout-hc");
                                        // EventBus.$emit("enable-atender");
                                        this.$router.push("/medico");
                                    });
                            })
                            .catch(err => console.log(err.response.data));
                    }
                });
            },
            cronometro() {
                if (this.Fecha_hora_ingreso.Datetimeingreso) {
                    this.cronos = setInterval(this.crono, 1000);
                }
            },
            crono() {
                let diff = moment().diff(
                    // moment("2019-08-13 13:10:06", "YYYY-MM-DD HH:mm:ss")
                    moment(this.Fecha_hora_ingreso.Datetimeingreso, "YYYY-MM-DD HH:mm:ss")
                );
                let duration = moment.duration(diff);
                let hour = 0;
                let minutes = 0;
                let second = 0;

                if (duration.hours() < 10) hour = `0${duration.hours()}`;
                else hour = duration.hours();

                if (duration.minutes() < 10) minutes = `0${duration.minutes()}`;
                else minutes = duration.minutes();

                if (duration.seconds() < 10) second = `0${duration.seconds()}`;
                else second = duration.seconds();

                this.time = `${hour}:${minutes}:${second}`;
            },
            enviar() {
                console.log(this.observaciones);
                if (!this.observaciones) {
                    swal({
                        title: "Espera",
                        text: "Es necesario definir una razón para poner en espera la cita!",
                        timer: 2000,
                        icon: "error",
                        buttons: false
                    });
                } else {
                    localStorage.removeItem("Gineco");
                    localStorage.removeItem("Diagnostico");
                    localStorage.removeItem("ExamenSistema");
                    localStorage.removeItem("MotivoConsulta");
                    localStorage.removeItem("AntecedentesPersonales");
                    localStorage.removeItem("AntecedentesFamiliares");
                    localStorage.removeItem("rcvm");
                    localStorage.removeItem("EstiloVida");
                    localStorage.removeItem("Conducta");
                    localStorage.removeItem("PacienteCedula");
                    EventBus.$emit("disable-layout-hc");
                    localStorage.removeItem("citapaciente_id");
                    // EventBus.$emit("enable-atender");
                    this.$router.push("/medico");
                }
            },
            cerrarModal() {
                this.dialog = false;
                this.observaciones = "";
            }
        }
    };
    //mariaca

</script>

<style scope>
</style>
