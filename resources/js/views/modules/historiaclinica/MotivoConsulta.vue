<template>
  <v-layout row wrap>
        <v-flex xs12>
            <v-stepper v-model="e6" vertical>
                <v-stepper-step :complete="e6 > 1" editable :edit-icon="$vuetify.icons.complete" step="1">
                    MC Y EA
                    <small>Motivo de consulta y enfermedad actual</small>
                </v-stepper-step>

                <v-stepper-content step="1">
                    <v-card color="lighten-1" class="mb-5" height="auto">
                        <v-container grid-list-xs>
                            <v-textarea
                                name="input-7-1"
                                label="Motivo de Consulta"
                                value=""
                                v-model="data.Motivoconsulta"
                            ></v-textarea>
                            <v-textarea
                                name="input-7-1"
                                label="Enfermedad Actual"
                                value=""
                                v-model="data.Enfermedadactual"
                            ></v-textarea>
                            <v-textarea
                                name="input-7-1"
                                label="Resultados de Ayudas Diagnosticas"
                                value=""
                                v-model="data.Resultayudadiagnostica"
                            ></v-textarea>
                        </v-container>
                    </v-card>
                    <v-btn color="primary" round @click="guardarMotivoConsulta()">Guardar y seguir</v-btn>
                </v-stepper-content>

                <v-stepper-step :complete="e6 > 2" editable :edit-icon="$vuetify.icons.complete" step="2">Revisión por sistema</v-stepper-step>

                <v-stepper-content step="2">
                    <v-card color="lighten-1" class="mb-5" height="auto">
                        
                        <v-container fluid>
                            <v-layout row>
                            <v-flex
                                grow
                                pa-1
                            >
                                <v-card
                                color="lighten-1" class="mb-5" height="auto"
                                >
                                <v-card-text >
                                    <v-flex xs12>
                                <v-layout row wrap>
                                    <v-switch
                                    color="primary"
                                    v-model="data.a"
                                    label="Oftalmológico"
                                    ></v-switch>
                                </v-layout>
                                <v-text-field 
                                    label="Oftalmológico" 
                                    v-show="data.a" 
                                    v-model="data.Oftalmologico">
                                </v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-switch
                                    color="primary"
                                    v-model="data.b"
                                    label="Genitourinario"
                                    :value="data.b"
                                    ></v-switch>
                                    <v-text-field 
                                        label="Genitourinario" 
                                        v-show="data.b"
                                        v-model="data.Genitourinario"
                                        > 
                                    </v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-switch
                                    color="primary"
                                    v-model="data.c"
                                    label="Otorrinolaringológico"
                                    ></v-switch>
                                    <v-text-field 
                                        label="Otorrinolaringológico" 
                                        v-show="data.c"
                                        v-model="data.Otorrinoralingologico"> 
                                    </v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-switch
                                    color="primary"
                                    v-model="data.d"
                                    label="Linfático"
                                    ></v-switch>
                                    <v-text-field 
                                        label="Linfático" 
                                        v-show="data.d"
                                        v-model="data.Linfatico"> 
                                    </v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-switch
                                    color="primary"
                                    v-model="data.f"
                                    label="Osteomioarticular"
                                    ></v-switch>
                                    <v-text-field 
                                        label="Osteomioarticular" 
                                        v-show="data.f"
                                        v-model="data.Osteomioarticular"> 
                                    </v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-switch
                                    color="primary"
                                    v-model="data.g"
                                    label="Neurológico"
                                    ></v-switch>
                                    <v-text-field 
                                        label="Neurológico" 
                                        v-show="data.g"
                                        v-model="data.Neurologico"> 
                                    </v-text-field>
                            </v-flex>
                                </v-card-text>
                                </v-card>
                            </v-flex>
                            <v-flex
                                grow
                                pa-1
                            >
                                <v-card
                                color="lighten-1" class="mb-5" height="auto"
                                >
                                <v-card-text>
                            <v-flex xs12>
                                <span></span>
                                <v-switch
                                    color="primary"
                                    v-model="data.h"
                                    label="Cardiovascular:"
                                    ></v-switch>
                                    <v-text-field 
                                        label="Cardiovascular" 
                                        v-show="data.h"
                                        v-model="data.Cardiovascular"> 
                                    </v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-switch
                                    color="primary"
                                    v-model="data.i"
                                    label="Tegumentario"
                                    ></v-switch>
                                    <v-text-field 
                                        label="Tegumentario" 
                                        v-show="data.i"
                                        v-model="data.Tegumentario"> 
                                    </v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-switch
                                    color="primary"
                                    v-model="data.j"
                                    label="Respiratorio"
                                    ></v-switch>
                                    <v-text-field 
                                        label="Respiratorio" 
                                        v-show="data.j"
                                        v-model="data.Respiratorio">
                                    </v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-switch
                                    color="primary"
                                    v-model="data.k"
                                    label="Endocrinológico"
                                    ></v-switch>
                                    <v-text-field 
                                        label="Endocrinológico" 
                                        v-show="data.k"
                                        v-model="data.Endocrinologico">
                                    </v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-switch
                                    color="primary"
                                    v-model="data.l"
                                    label="Gastrointestinal:"
                                    ></v-switch>
                                    <v-text-field 
                                        label="Gastrointestinal" 
                                        v-show="data.l"
                                        v-model="data.Gastrointestinal"> 
                                    </v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-switch
                                    color="primary"
                                    v-model="data.m"
                                    label="Otros"
                                    ></v-switch>
                                    <v-text-field 
                                        label="Otros" 
                                        v-show="data.m"
                                        v-model="data.Norefiere"> 
                                    </v-text-field>
                            </v-flex>
                                </v-card-text>
                                </v-card>
                            </v-flex>
                            </v-layout>
                        </v-container>
                        <v-btn color="primary" round @click="guardarRevisionsisitema()">Guardar</v-btn>
                    </v-card>
                </v-stepper-content>
            </v-stepper>
        </v-flex>
  </v-layout>
</template>
<script>
    import {EventBus} from '../../../event-bus.js';

    export default {
        created() {
            this.removeLocalStorage();
            this.citaPaciente = this.$route.query.cita_paciente;
            this.getLocalStorage();
        },
        data() {
            return {
                e6: 1,
                data: { Motivoconsulta: '', Enfermedadactual: '', Resultayudadiagnostica: '', Oftalmologico: '', Genitourinario: '', Otorrinoralingologico: '', 
                Linfatico: '', Osteomioarticular: '', Neurologico: '', Cardiovascular: '', Tegumentario: '', Respiratorio: ''
                , Endocrinologico: '', Gastrointestinal: '', Norefiere: ''},
                citaPaciente: 0
                
            }
        },

        mounted() {
            
            // this.fetchAnamnesis();
        },

        methods: {

            fetchAnamnesis() {
                axios.get('/api/cita/'+this.citaPaciente+'/motivo')
                    .then(res => { 
                        this.data = res.data;
                        // (this.data.Oftalmologico)? this.data.a = true : this.data.a = false;
                        // (this.data.Genitourinario)? this.data.b = true : this.data.b = false;
                        // (this.data.Otorrinoralingologico)? this.data.c = true : this.data.c = false;
                        // (this.data.Linfatico)? this.data.d = true : this.data.d = false;
                        // (this.data.Osteomioarticular)? this.data.f = true : this.data.f = false;
                        // (this.data.Neurologico)? this.data.g = true : this.data.g = false;
                        // (this.data.Cardiovascular)? this.data.h = true : this.data.h = false;
                        // (this.data.Tegumentario)? this.data.i = true : this.data.i = false;
                        // (this.data.Respiratorio)? this.data.j = true : this.data.j = false;
                        // (this.data.Endocrinologico)? this.data.k = true : this.data.k = false;
                        // (this.data.Gastrointestinal)? this.data.l = true : this.data.l = false;
                        // (this.data.Norefiere)? this.data.m = true : this.data.m = false;
                    });
            },

            guardarMotivoConsulta() {
              // console.log(this.data)
                if (this.data.Motivoconsulta.length < 5) {
                    swal("Motivo consulta debe ser mayor a 5 caracteres")
                    return;
                }

                if (this.data.Enfermedadactual.length < 20) {
                    swal("Enfermedad actual debe ser mayor a 20 caracteres")
                    return;
                }

                axios.post('/api/cita/'+this.citaPaciente+'/motivo',this.data).then((res) => {
                    this.e6 = 2;
                    localStorage.setItem("MotivoConsulta", JSON.stringify(this.data));
                    //EventBus.$emit('change_disabled_list_history','ANTECEDENTES')
                });

            },
            guardarRevisionsisitema() {

                axios.post('/api/cita/'+this.citaPaciente+'/revisionsistema',this.data).then((res) => {
                    this.e6 = 3;
                    localStorage.setItem("MotivoConsulta", JSON.stringify(this.data));
                    this.$router.push('/historiaclinica/patologias?cita_paciente='+this.citaPaciente);
                    
                    // EventBus.$emit('change_disabled_list_history','ANTECEDENTES')
                })
            },
            getLocalStorage() {
                let motivo = JSON.parse(localStorage.getItem("MotivoConsulta"));
                if (motivo) {
                    this.data = motivo;
                } else {
                    this.fetchAnamnesis();
                }
            },
            removeLocalStorage() {
                localStorage.removeItem("Gineco");
                localStorage.removeItem("Diagnostico");
                localStorage.removeItem("ExamenSistema");
                localStorage.removeItem("MotivoConsulta");
                localStorage.removeItem("AntecedentesPersonales");
                localStorage.removeItem("AntecedentesFamiliares");
                localStorage.removeItem("rcvm");
                localStorage.removeItem("EstiloVida");
                localStorage.removeItem("Conducta");
            }
        }
    }
</script>
<style scoped>
    
</style>