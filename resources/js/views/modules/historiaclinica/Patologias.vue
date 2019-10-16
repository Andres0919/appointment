<template>
    <v-layout row wrap>
        <v-flex xs12>
            <v-stepper v-model="e6" vertical>
                <v-stepper-step :complete="e6 > 1" editable :edit-icon="$vuetify.icons.complete" step="1">ANTECEDENTES
                    PERSONALES</v-stepper-step>

                <v-stepper-content step="1">
                    <v-card color="lighten-1" class="mb-5" height="auto">
                        <v-container grid-list-xs>
                            <v-layout row wrap>
                                <v-flex xs4 px-1 :key="antecedente.id" v-for="antecedente in antecedentes">
                                    <v-switch color="primary" v-model="pacienteantecedente" :value="antecedente"
                                        :label="antecedente.Nombre"></v-switch>
                                    <v-text-field :label="`Descripción ${antecedente.Nombre}`"
                                        v-show="pacienteantecedente.find((ant) => ant.id == antecedente.id)"
                                        v-model="antecedente.Descripcion"></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card>
                    <v-btn color="primary" round @click="guardarAntecendente()">Guardar y seguir</v-btn>
                </v-stepper-content>

                <v-stepper-step :complete="e6 > 2" editable :edit-icon="$vuetify.icons.complete" step="2">ANTECEDENTES
                    FAMILIARES</v-stepper-step>

                <v-stepper-content step="2">
                    <v-card color="lighten-1" class="mb-5" height="auto">
                        <v-container grid-list-xs>
                            <v-layout row wrap>
                                <v-flex xs4 px-1 :key="antecedente.id" v-for="antecedente in antecedentes" orderBy sortKey desc>
                                    <v-flex xs12 v-if="antecedente.Esfamiliar == 1">
                                        <v-select :input="data.Descripcion" :items="parentesco"
                                            v-on:change="selectAntecedentes($event,antecedente)" item-text="Nombre"
                                            :label="antecedente.Nombre" item-value="id" multiple chips></v-select>
                                        <!-- <v-text-field :label="`Descripción ${antecedente.Nombre}`"
                                            @input="escribir($event, antecedente)"
                                            v-show="isIdAntecedente(antecedente.id)"></v-text-field> -->
                                    </v-flex>
                                </v-flex>
                            </v-layout>
                        </v-container>
                        <v-btn color="primary" round @click="guardarParentesco()">Guardar</v-btn>
                    </v-card>
                </v-stepper-content>
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
            this.citaPaciente = this.$route.query.cita_paciente;
            EventBus.$on("recibir-paciente-examen-fisico", paciente => {
      this.paciente = paciente;
    });
        },
        data() {
            return {
                e6: 1,
                antecedentes: [],
                parentesco: [],
                pacienteantecedente: [],
                parentescoantecedentes: [],
                citaPaciente: 0,
                data: {
                    Descripcion: ""
                }
            };
        },

        mounted() {
            this.fetchAntecedentes();
            this.fetchParentesco();
            this.fetchAntecedentespersonales();
        },
        methods: {
          
    getPaciente() {
      if (this.paciente == null) {
        EventBus.$emit("enviar-paciente", "recibir-paciente-examen-fisico");
      }
    },
            fetchAntecedentespersonales() {
                axios
                    .get("/api/pacienteantecedente/antecedentes/" + this.citaPaciente + "")
                    .then(res => {
                        res.data.forEach(dat => {
                            this.pacienteantecedente.push(dat);
                            let ant = this.antecedentes.find(a => a.id == dat.id);
                            if (ant) ant.Descripcion = dat.Descripcion;
                        });
                    });
            },

            fetchAntecedentes() {
                axios
                    .get("/api/antecedente/all")
                    .then(res => (this.antecedentes = res.data));
            },

            fetchParentesco() {
                axios
                    .get("/api/parentesco/all")
                    .then(res => (this.parentesco = res.data));
            },

            guardarAntecendente() {
                axios
                    .post(
                        "/api/pacienteantecedente/create/" + this.citaPaciente,
                        this.pacienteantecedente
                    )
                    .then(res => {
                        console.log(res.data);
                    })
                    .catch(err => console.log(err.response.data));
                this.e6 = 2;
                // console.log(this.pacienteantecedente)
            },
            isIdAntecedente(id) {
                return this.parentescoantecedentes.find(ant => ant.id == id);
            },
            selectAntecedentes(e, ant) {
                let isAntecedente = this.isIdAntecedente(ant.id);
                if (isAntecedente) {
                    isAntecedente.familiares = e;
                    if (e.length == 0) {
                        for (let i = 0; i < this.parentescoantecedentes.length; i++) {
                            if (this.parentescoantecedentes[i].id == ant.id) {
                                this.parentescoantecedentes.splice(i, 1);
                                break;
                            }
                        }
                    }
                } else {
                    this.parentescoantecedentes.push({
                        id: ant.id,
                        familiares: e,
                        Descripcion: ""
                    });
                }
            },
            escribir(e, ant) {
                let isAntecedente = this.isIdAntecedente(ant.id);
                if (isAntecedente) {
                    isAntecedente.Descripcion = e;
                }
            },
            guardarParentesco() {
              this.getPaciente();
                EventBus.$emit("change_disabled_list_history", "ANTECEDENTES");
                axios.post("/api/parentescoantecedente/create/" + this.citaPaciente, this.parentescoantecedentes)
                    .then(res => {
                        this.e6 = 3;
                        if (this.paciente.Sexo == "F") {
                            this.$router.push(
                                "/historiaclinica/gineco?cita_paciente=" + this.citaPaciente
                            );
                            EventBus.$emit(
                                "change_disabled_list_history",
                                "ANTECEDENTES GINECO OBSTÉTRICOS"
                            );
                        } else {
                            this.$router.push(
                                "/historiaclinica/stylelive?cita_paciente=" + this.citaPaciente
                            );
                            EventBus.$emit("change_disabled_list_history", "ESTILOS DE VIDA");
                        }
                    });
            }
        }
    };

</script>
<style scoped>
</style>
